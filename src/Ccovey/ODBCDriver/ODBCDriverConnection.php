<?php namespace Ccovey\ODBCDriver;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Grammars\Grammar as IllGrammar;
use Illuminate\Database\Schema\Grammars\Grammar as SchemaGrammar;

class ODBCDriverConnection extends Connection
{
	/**
	 * @return Query\Grammars\Grammar
	 */
	protected function getDefaultQueryGrammar()
	{
		$grammarConfig = $this->getGrammarConfig();

		if ($grammarConfig) {
			$packageGrammar = "Ccovey\\ODBCDriver\\Grammars\\" . $grammarConfig; 
			if (class_exists($packageGrammar)) {
				return $this->withTablePrefix(new $packageGrammar);
			}
			
			$illuminateGrammar = "IGrammar\\" . $grammarConfig;
			if (class_exists($illuminateGrammar)) {
				return $this->withTablePrefix(new $illuminateGrammar);
			}
		}

		return $this->withTablePrefix(new IllGrammar);
	}

	/**
	 * Default grammar for specified Schema
	 * @return Schema\Grammars\Grammar
	 */
	protected function getDefaultSchemaGrammar()
	{
		return $this->withTablePrefix(new SchemaGrammar);
	}

	protected function getGrammarConfig()
	{
		if ($this->getConfig('grammar')) {
			return $this->getConfig('grammar');
		}

		return false;
	}
}
