### Database and Data Structure
Here is a Sqlite3 database which stores all the routes from different origins. The data has been structured as the representation bellow:

|id|src|dst|distance (km)|
|:-:|---|---|---|:-:|
|1|AAE|ALG|409.44810258218|
|2|AAE|CDG|1420.6047935719|
|3|AAE|IST|1870.3866766873|
|4|AAE|LYS|1015.604132942|
|...|

**Note:** All the invalid routes have been removed as there was no such IATA code in the airports dataset. 

**Note:** The calculation of distances has been done through the class *\Application\Service\GeoService*. 