# symfony-elastic
Elasticsearch 6.7.2 with Symfony 5.2.1

> 'elasticsearch/elasticsearch' has been used as elastic package. 

http://localhost:32769/_cat/indices

http://localhost:32769/person/_search?size=1000



# How to use?

First of all,

Running this command: `bin/console elastic:populate:person`

And after,

> With Form: http://localhost:port/elastic/autocomplete/

> With Api Call: http://localhost:port/elastic/autocomplete/?term=ank
