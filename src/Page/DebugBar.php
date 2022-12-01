<?php
namespace Sy\Component\Html\Page;

use Sy\Component\WebComponent,
	Sy\Debug\Debugger,
	Sy\Debug\Log;

class DebugBar extends WebComponent {

	private $charset;

	private $colorNames = array(
		Log::EMERG  => 'red',
		Log::ALERT  => 'red',
		Log::CRIT   => 'red',
		Log::ERR    => 'red',
		Log::WARN   => 'orange',
		Log::NOTICE => 'green',
		Log::INFO   => 'green',
		Log::DEBUG  => 'green',
	);

	private $colors = array(
		Log::EMERG  => '#FBB',
		Log::ALERT  => '#FBB',
		Log::CRIT   => '#FBB',
		Log::ERR    => '#FBB',
		Log::WARN   => '#FB5',
		Log::NOTICE => '#DDE4EB',
		Log::INFO   => '#DDE4EB',
		Log::DEBUG  => '#DDE4EB',
	);

	private $sColors = array(
		Log::EMERG  => '#FDD',
		Log::ALERT  => '#FDD',
		Log::CRIT   => '#FDD',
		Log::ERR    => '#FDD',
		Log::WARN   => '#FD7',
		Log::NOTICE => '#EDF3FE',
		Log::INFO   => '#EDF3FE',
		Log::DEBUG  => '#EDF3FE',
	);

	/**
	 * Reset css
	 *
	 * @var string
	 */
	private $resetCss = 'margin: 0; padding: 0; border: 0; outline: 0; font-family: sans-serif; font-size: 100%; font-style: normal; font-weight: normal; vertical-align: baseline; background: transparent; float: none; color: #000; line-height: 15px;';

	/**
	 * Reset table css
	 *
	 * @var string
	 */
	private $tableResetCss;

	/**
	 * Reset first tr css
	 *
	 * @var string
	 */
	private $trHeadCss = 'margin: 0 !important; padding: 0 !important; border: 0 !important; outline: 0 !important; font-size: 100% !important; vertical-align: middle !important; background-color: #0065BD !important; color: white !important;';

	/**
	 * Reset th css
	 *
	 * @var string
	 */
	private $thCss = 'margin: 0 !important; padding: 3px !important; border-bottom: 1px solid #004887 !important; border-right: 1px solid #004887 !important; outline: 0 !important; font-size: 100% !important; font-weight: bold !important; vertical-align: middle !important; color: white !important; text-align: center !important;';

	/**
	 * Reset td css
	 *
	 * @var string
	 */
	private $tdCss = 'margin: 0 !important; padding: 3px !important; border-bottom: 1px solid #B4B4B4 !important; border-right: 1px solid #B4B4B4 !important; outline: 0; font-size: 100% !important; vertical-align: middle !important; color: black !important; background: transparent !important;';

	public function __construct($charset) {
		parent::__construct();
		$this->setTemplateFile(__DIR__ . '/templates/DebugBar.tpl', 'php');
		$this->charset = $charset;
		$this->tableResetCss = $this->resetCss . ' border-collapse: separate; border-spacing: 0;';
		$this->init();
	}

	private function init() {
		$this->initPhpInfoDiv();
		$this->initVarsDiv();
		$this->initLogsDiv();
		$this->initLogFileDiv();
		$this->initQueryDiv();
		$this->initTimeRecordDiv();
		$this->resetCss();
	}

	/**
	 * PHP Info division
	 */
	private function initPhpInfoDiv() {
		$debugger = Debugger::getInstance();
		$this->setVar('CHARSET', $this->charset);
		$this->setVar('PHP_INFO', $debugger->phpInfoActive());
	}

	/**
	 * Vars division
	 */
	private function initVarsDiv() {
		$constants = get_defined_constants(true);
		$varsArray['User Constants']      = isset($constants['user']) ? $constants['user'] : array();
		$varsArray['$_REQUEST Variables'] = $_REQUEST;
		$varsArray['$_GET Variables']     = $_GET;
		$varsArray['$_POST Variables']    = $_POST;
		$varsArray['$_COOKIE Variables']  = $_COOKIE;
		if (session_id()) $varsArray['$_SESSION Variables'] = $_SESSION;
		$varsArray['$_FILES Variables']   = $_FILES;
		$varsArray['$_SERVER Variables']  = $_SERVER;

		$varsDiv = '';
		foreach ($varsArray as $title => $vars) {
			if (empty($vars)) continue;
			$rows = '';
			foreach ($vars as $k => $v) {
				if (is_null($v)) continue;
				if (is_array($v) or is_object($v)) {
					$value = '<pre style="' . $this->resetCss . '">' . htmlentities(print_r($v, true), ENT_QUOTES, $this->charset) . '</pre>';
				} else {
					$value = htmlentities($v, ENT_QUOTES, $this->charset);
				}
				$rows .= <<<TR
					<tr style="{$this->resetCss}">
						<td style="{$this->tdCss} background-color: #DDE4EB; font-weight: bold;">$k</td>
						<td style="{$this->tdCss} background-color: #EDF3FE">
							$value
						</td>
					</tr>
TR;
			}
			$varsDiv .= <<<VARS_DIV
				<h2 style="{$this->resetCss} font-size: 14px; margin: 10px; line-height: 20px;">$title</h2>
				<table style="{$this->tableResetCss} width: 100%;">
					<tr style="{$this->trHeadCss}">
						<th style="{$this->thCss} width: 200px;">Name</th>
						<th style="{$this->thCss}">Value</th>
					</tr>
					$rows
				</table>
VARS_DIV;
		}
		$this->setVar('VARS_DIV', $varsDiv);

		// Files
		$files = '';
		foreach (get_included_files() as $file) {
			$files .= <<<FILES
				<tr style="{$this->resetCss}">
					<td style="{$this->tdCss} background-color: #EDF3FE">$file</td>
				</tr>
FILES;
		}
		$this->setVar('FILES', $files);
	}

	/**
	 * Logs division
	 */
	private function initLogsDiv() {
		$debugger = Debugger::getInstance();
		$this->setVar('WEB_LOGGER', $debugger->webLogActive());
		if (!$debugger->webLogActive()) return;
		$loggers  = $debugger->getLoggers();
		$nb = $loggers['web']->getNbError();
		switch ($nb) {
			case 0:
				$nbError = '';
				break;
			case 1:
				$nbError = $nb . ' error';
				break;
			default:
				$nbError = $nb . ' errors';
				break;
		}
		$this->setVar('NB_ERROR',  $nbError);

		$flag = array(
			'green'  => '<svg style="height: 14px; color: green" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M349.565 98.783C295.978 98.783 251.721 64 184.348 64c-24.955 0-47.309 4.384-68.045 12.013a55.947 55.947 0 0 0 3.586-23.562C118.117 24.015 94.806 1.206 66.338.048 34.345-1.254 8 24.296 8 56c0 19.026 9.497 35.825 24 45.945V488c0 13.255 10.745 24 24 24h16c13.255 0 24-10.745 24-24v-94.4c28.311-12.064 63.582-22.122 114.435-22.122 53.588 0 97.844 34.783 165.217 34.783 48.169 0 86.667-16.294 122.505-40.858C506.84 359.452 512 349.571 512 339.045v-243.1c0-23.393-24.269-38.87-45.485-29.016-34.338 15.948-76.454 31.854-116.95 31.854z"></path></svg>',
			'orange' => '<svg style="height: 14px; color: orange" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M349.565 98.783C295.978 98.783 251.721 64 184.348 64c-24.955 0-47.309 4.384-68.045 12.013a55.947 55.947 0 0 0 3.586-23.562C118.117 24.015 94.806 1.206 66.338.048 34.345-1.254 8 24.296 8 56c0 19.026 9.497 35.825 24 45.945V488c0 13.255 10.745 24 24 24h16c13.255 0 24-10.745 24-24v-94.4c28.311-12.064 63.582-22.122 114.435-22.122 53.588 0 97.844 34.783 165.217 34.783 48.169 0 86.667-16.294 122.505-40.858C506.84 359.452 512 349.571 512 339.045v-243.1c0-23.393-24.269-38.87-45.485-29.016-34.338 15.948-76.454 31.854-116.95 31.854z"></path></svg>',
			'red'    => '<svg style="height: 14px; color: red" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M349.565 98.783C295.978 98.783 251.721 64 184.348 64c-24.955 0-47.309 4.384-68.045 12.013a55.947 55.947 0 0 0 3.586-23.562C118.117 24.015 94.806 1.206 66.338.048 34.345-1.254 8 24.296 8 56c0 19.026 9.497 35.825 24 45.945V488c0 13.255 10.745 24 24 24h16c13.255 0 24-10.745 24-24v-94.4c28.311-12.064 63.582-22.122 114.435-22.122 53.588 0 97.844 34.783 165.217 34.783 48.169 0 86.667-16.294 122.505-40.858C506.84 359.452 512 349.571 512 339.045v-243.1c0-23.393-24.269-38.87-45.485-29.016-34.338 15.948-76.454 31.854-116.95 31.854z"></path></svg>',
		);
		$flags = array(
			Log::EMERG  => $flag['red'],
			Log::ALERT  => $flag['red'],
			Log::CRIT   => $flag['red'],
			Log::ERR    => $flag['red'],
			Log::WARN   => $flag['orange'],
			Log::NOTICE => $flag['green'],
			Log::INFO   => $flag['green'],
			Log::DEBUG  => $flag['green'],
		);
		$this->setVars([
			'FLAG_NOTICE' => $flag['green'],
			'FLAG_WARN'   => $flag['orange'],
			'FLAG_ERR'    => $flag['red'],
		]);

		$logsDiv = '';
		foreach ($loggers['web']->getLogs() as $log) {
			$filename = basename($log->getFile());
			$message = htmlentities($log->getMessage(), ENT_QUOTES, $this->charset);
			$logsDiv .= <<<LOGS_DIV
				<tr class="sy_debug_log_row_{$this->colorNames[$log->getLevel()]}" style="{$this->resetCss}">
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">
						<div style="display: inline-block">{$flags[$log->getLevel()]}</div>
						{$log->getLevelName()}
					</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">{$log->getType()}</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}"><span style="{$this->resetCss}" title="{$log->getFile()}">$filename</span></td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}; text-align: right;">{$log->getLine()}</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">{$log->getClass()}</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">{$log->getFunction()}</td>
					<td style="{$this->tdCss} background-color: {$this->sColors[$log->getLevel()]}"><pre style="{$this->resetCss}">$message</td>
				</tr>
LOGS_DIV;
		}
		$this->setVar('LOGS_DIV', $logsDiv);
	}

	/**
	 * Log file division
	 */
	private function initLogFileDiv() {
		$debugger = Debugger::getInstance();
		$this->setVar('FILE_LOGGER', $debugger->fileLogActive());
	}

	/**
	 * Query division
	 */
	private function initQueryDiv() {
		$debugger = Debugger::getInstance();
		$this->setVar('QUERY_LOGGER', $debugger->queryLogActive());
		if (!$debugger->queryLogActive()) return;
		$loggers = $debugger->getLoggers();
		$nb = count($loggers['query']->getLogs());
		switch ($nb) {
			case 0:
				$nbQuery = 'No Query';
				break;
			case 1:
				$nbQuery = $nb . ' Query';
				break;
			default:
				$nbQuery = $nb . ' Queries';
				break;
		}
		$this->setVar('NB_QUERY',  $nbQuery);

		// Query logs
		$queryLogs = '';
		foreach ($loggers['query']->getLogs() as $i => $log) {
			$n = $i + 1;
			$filename = basename($log->getFile());
			$message = htmlentities($log->getMessage(), ENT_QUOTES, $this->charset);
			$queryLogs .= <<<QUERY
				<tr style="{$this->resetCss}">
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">{$n}</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}"><span style="{$this->resetCss}" title="{$log->getFile()}">$filename</span></td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}; text-align: right;">{$log->getLine()}</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">{$log->getClass()}</td>
					<td style="{$this->tdCss} background-color: {$this->colors[$log->getLevel()]}">{$log->getFunction()}</td>
					<td style="{$this->tdCss} background-color: {$this->sColors[$log->getLevel()]}"><pre style="{$this->resetCss}">$message</pre></td>
				</tr>
QUERY;
		}
		$this->setVar('QUERY_LOGS', $queryLogs);
	}

	/**
	 * Time record division
	 */
	private function initTimeRecordDiv() {
		$debugger = Debugger::getInstance();
		$this->setVar('TIME_RECORD', $debugger->timeRecordActive());
		if (!$debugger->timeRecordActive()) return;
		$times = $debugger->getTimes();
		$maxTime = empty($times) ? 'No time' : round(max($times) * 1000) . ' ms';
		$this->setVar('MAX_TIME', $maxTime);

		// Times
		$timeLogs = '';
		foreach ($times as $title => $time) {
			$t = round($time * 1000, 2);
			$timeLogs .= <<<TIMES
			<tr style="{$this->resetCss}">
				<td style="{$this->tdCss} background-color: #DDE4EB">$title</td>
				<td style="{$this->tdCss} background-color: #EDF3FE; text-align: right; padding-right: 10px;">$t</td>
			</tr>
TIMES;
		}
		$this->setVar('TIMES', $timeLogs);
	}

	private function resetCss() {
		$this->setVar('RESET_CSS', $this->resetCss);
		$this->setVar('TABLE_RESET_CSS', $this->tableResetCss);
		$this->setVar('TR_HEAD_CSS', $this->trHeadCss);
		$this->setVar('TH_CSS', $this->thCss);
	}

}