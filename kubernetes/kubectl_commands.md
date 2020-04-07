kubectl cluster-info

kubectl get nodes

kubectl get pods

kubetl describe pods

#Create deployment
#We need to provide the deployment name and app image location
#1) searched for a suitable node where an instance of the application could be run (we have only 1 available node)
#2) scheduled the application to run on that Node
#3) configured the cluster to reschedule the instance on a new Node when needed
kubectl create deployment kubernetes-bootcamp --image=gcr.io/google-samples/kubernetes-bootcamp:v1
kubectl get deployments
kubectl delete deployment kubernetes-bootcamp


#Proxy
#The kubectl command can create a proxy that will forward communications into the cluster-wide, private network
echo -e "\n\n\n\e[92mStarting Proxy. After starting it will not output a response. Please click the first Terminal Tab\n"; 
kubectl proxy

#You can see all those APIs hosted through the proxy endpoint, for example:
curl http://localhost:8001/version

#Save POD Name into env variable:
export POD_NAME=$(kubectl get pods -o go-template --template '{{range .items}}{{.metadata.name}}{{"\n"}}{{end}}')
echo Name of the Pod: $POD_NAME

#With the $POD_NAME from previous step we can request the POD via the proxy
curl http://localhost:8001/api/v1/namespaces/default/pods/$POD_NAME/proxy/

kubectl logs $POD_NAME 

#List Env variables (the name of the container itself can be omitted since we only have a single container in the Pod.)
kubectl exec $POD_NAME env

#Open bash terminal in POD
kubectl exec -ti $POD_NAME bash

###########
#SERVICES##
###########
#a serice is a set of pods to expose, 4 types:
#-ClusterIP: Exposes the Service on an internal IP in the cluster. This type makes the Service only reachable from within the cluster.
#-NodePort: Exposes the Service on the same port of each selected Node in the cluster using NAT. Makes a Service accessible from outside the cluster using              #<NodeIP>:<NodePort>. Superset of ClusterIP.
#-LoadBalancer: Creates an external load balancer in the current cloud (if supported) and assigns a fixed, external IP to the Service. Superset of NodePort
#-ExternalName: Exposes the Service using an arbitrary name (specified by externalName in the spec) by returning a CNAME record with the name. No proxy is              used. This type requires v1.7 or higher of kube-dns.

#To create a new service and expose it to external traffic we’ll use the expose command with NodePort as parameter
#kubectl expose deployment/kubernetes-bootcamp --type="NodePort" --port 8080

#Describe service called kubernetes-bootcamp
kubectl describe services/kubernetes-bootcamp

#Environment variable called NODE_PORT that has the value of the Node port assigned
export NODE_PORT=$(kubectl get services/kubernetes-bootcamp -o go-template='{{(index .spec.ports 0).nodePort}}')
echo NODE_PORT=$NODE_PORT

#Get Label of deployment
kubectl describe deployment
#With this label (in this case: run=kubernetes-bootcam)
#we can get Pods/Services from the deployment
kubectl get pods -l run=kubernetes-bootcamp
kubectl get services -l run=kubernetes-bootcamp


#Reach service from outside the cluster
curl {cluster_ip}:$NODE_PORT

#Set label to pod (new label: app=v1)
kubectl label pod $POD_NAME app=v1

#Delete services (-l: by label, run=kubernetes-bootcamp is the deployment label)
kubectl delete service -l run=kubernetes-bootcamp

#########
#SCALING#
#########
#Scaling is accomplished by changing the number of replicas in a Deployment

#see the ReplicaSet created by the Deployment
#DESIRED displays the desired number of replicas of the application, which you define when you create the Deployment. This is the           #desired state.
#CURRENT displays how many replicas are currently running.
kubectl get rs

#scale the Deployment to 4 replicas
kubectl scale deployments/kubernetes-bootcamp --replicas=4

#Update an application
#To update the image of the application to version 2, use the set image command, followed by the deployment name and the new #image version:
kubectl set image deployments/kubernetes-bootcamp kubernetes-bootcamp=jocatalin/kubernetes-bootcamp:v2








kubectl create deployment backend-deployment --image=be:v1
kubectl expose deployment/backend-deployment --type="NodePort" --port 9000
export NODE_PORT=$(kubectl get services/backend-deployment -o go-template='{{(index .spec.ports 0).nodePort}}')

curl 10.103.54.153:$NODE_PORT/api/v1/products?page=1 -H "accept: application/ld+json"


curl 10.103.54.153/api/v1/products?page=1 -H "accept: application/ld+json":$NODE_PORT