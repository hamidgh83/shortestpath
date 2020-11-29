### Overview
This project is to build a JSON over HTTP API endpoint that takes as input two IATA airport codes and provides as output a route between these two airports. The route consists of at most 4 legs/flights (that is, 3 stops/layovers, if going from A->B, a valid route could be A->1->2->3->B, or for example A->1->B etc.). It is also the shortest such route as measured in kilometers of geographical distance.

### Installation

After cloning the repository, you can run the project as follows:

- ##### Using docker-compose

This project has been dockerized, so that you don't need to install anything to run it. The only thing you need to install is docker-compose and run it as follow:

```bash
$ docker-compose up -d 
```

Then the application will run at port 8000 and you can get access to it via http://localhost:8000.

### Data structure

This project uses Sqlite3 to store the information of 3282 airports and their routes to other airports. You can find the database at **[data](https://github.com/hamidgh83/shortestpath/tree/master/data)** directory

### How it works

After running the application you can refer to http://localhost:8000/swagger/ to see the API documentation. The documentation has been generated with style of OpenAPI v3.0 and it is represented using SwaggerUI.