<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class UITests extends TestCase
{
    protected $webDriver;
    protected $baseUrl = 'http://172.19.0.6:80'; // Usar la IP interna del contenedor app

    protected function setUp(): void
    {
        $host = 'http://selenium-hub:4444/wd/hub';
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 60000, 60000); // 60s timeout
    }

    protected function tearDown(): void
    {
        $this->webDriver->quit();
    }

    protected function waitForAppReady($url, $timeout = 60)
    {
        $start = time();
        do {
            try {
                $this->webDriver->get($url);
                // Busca el texto "BIENVENIDO" en el h4 de la página de login
                $h4s = $this->webDriver->findElements(WebDriverBy::cssSelector('h4.login-title'));
                foreach ($h4s as $h4) {
                    if (stripos($h4->getText(), 'BIENVENIDO') !== false) {
                        return true;
                    }
                }
            } catch (\Exception $e) {
                // wait and retry
            }
            sleep(2);
        } while (time() - $start < $timeout);
        // Captura pantalla y HTML antes de lanzar la excepción
        try {
            $this->webDriver->takeScreenshot(__DIR__ . '/wait_failure.png');
            file_put_contents(__DIR__ . '/wait_failure.html', $this->webDriver->getPageSource());
        } catch (\Exception $e) {
            // Ignorar errores de captura
        }
        throw new \Exception('App not ready after waiting ' . $timeout . ' seconds');
    }

    public function testLoginFunctionality()
    {
        $this->waitForAppReady($this->baseUrl . '/home/login');
        try {
            $this->webDriver->get($this->baseUrl . '/home/login');
            $this->webDriver->findElement(WebDriverBy::name('usuario'))->sendKeys('admin');
            $this->webDriver->findElement(WebDriverBy::name('clave'))->sendKeys('admin12345');
            $this->webDriver->findElement(WebDriverBy::id('btnAccion'))->click();
            $this->webDriver->wait(20, 500)->until(function ($driver) {
                try {
                    $h4 = $driver->findElement(WebDriverBy::cssSelector('h4.login-title'));
                    return stripos($h4->getText(), 'BIENVENIDO') !== false ? $h4 : null;
                } catch (\Exception $e) {
                    return null;
                }
            });
            $this->assertStringContainsString(
                'BIENVENIDO',
                $this->webDriver->findElement(WebDriverBy::cssSelector('h4.login-title'))->getText()
            );
            // Captura de pantalla y HTML en éxito
            $this->webDriver->takeScreenshot(__DIR__ . '/login_success.png');
            file_put_contents(__DIR__ . '/login_success.html', $this->webDriver->getPageSource());
        } catch (\Exception $e) {
            $this->webDriver->takeScreenshot(__DIR__ . '/login_failure.png');
            file_put_contents(__DIR__ . '/login_failure.html', $this->webDriver->getPageSource());
            throw $e;
        }
    }
}