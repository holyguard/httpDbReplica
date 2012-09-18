<?

# sendSignal

include($_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/httpDbConf.php');

include($_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/core/funcs.core.php');


# job invia il segnale agli altri server
# gli altri server ricevuto il segnale puntano a questo server
# per scaricarsi il file queries.log

job('http://www.travelinhotel.com/httpDbReplica/receiver.php');