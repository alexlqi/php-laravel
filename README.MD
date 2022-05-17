I created this site using PHP 8.0 - MongoDB 5.0 with docker-compose 3.8

First I had to check the file and convert it from ANSI to UTF-8 without BOM
Then I created a Seeder to populate the collection with the processed data

After analyzing the data from the file I realized that it was unwinded using settlement
as uinwinded data. the pivot data point was zip_code.

Therefore, I created a loop that created a data structure as the api output example
and store every zip code with settlements as an array inside the main document

I thought that it would be better to process everything once and for all on docker up
and retrive the information already processed from mongodb.

Also, I used an apache load balancer to access the docker web service locally and
used letsencrypt certbot to make the site https