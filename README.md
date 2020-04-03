# symfony-playground

## Commands to setup docker containers

First we need to execute build command to pull the images and create the
containers

```bash
make build
```

Then, run containers.

```bash
make run
```

Finally, we'll need to apply migrations to database.

```bash
make apply-migrations
```

## Extra

To start containers :

```bash
make run
```

To stop containers :

```bash
make stop
```

In case of the database wasn't created, run the following command:

```bash
make recreate && make run
```

To connect to terminal into be server container:

```bash
make ssh-be
```

## Note

In case you are using Windows, you must use Docker with Windows Container and
git bash console with
[make](https://gist.github.com/evanwill/0207876c3243bbb6863e65ec5dc3f058).
command installed.
