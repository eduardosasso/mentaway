<?php
/**
* Implementa o conceito de Worker classe que fica esperando jobs entrarem no queue e vai executando
* Extender essa classe para implementar workers especificos para cada situacao
* Colocar no ar via linha de comando cada worker para rodar em paralelo.
* ex: php facebook/model/queue/workers/foursquare_worker.php
*/

include realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes.php';

abstract class Worker{
	function __construct() {
		$this->pheanstalk = new Pheanstalk('127.0.0.1:11300');
	}

	//tem q implementar esse metodo com a logica de processamento do job...
	abstract protected function process($data);

	public function run(){		
		//o nome do canal é o nome da classe worker q vai processar job.
		$tube = strtolower(get_class($this));

		//sempre rodando esperando um hob entrar...
		while(1) {
			$job = $this->pheanstalk->watch($tube)->ignore('default')->reserve();

			$data = json_decode($job->getData());
			
			try {
				$this->process($data);
			} catch (Exception $e) {
				Log::write($e->getMessage());
			}

			$this->pheanstalk->delete($job);

			usleep(10);
		}
	}

}
?>