<?php

namespace Shakyamouni\SiteBundle\Tests\Functional;

use Behat\MinkBundle\Test\MinkTestCase;
use Shakyamouni\UserBundle\Entity\User;

/**
 * Base class for tests
 *
 */
class MinkTestCaseBase extends MinkTestCase
{

    /**
     * base url.
     *
     * @var string
     */
    protected $base;

    /**
     * Browser session name.
     *
     * @var string
     */
    protected $sessionName = 'selenium2';

    /**
     * @var Behat\Mink\Session
     */
    protected $session;

    /**
     * If user is logged.
     *
     * @var boolean
     */
    protected static $isLogged = false;
    protected static $mockDb = false;
    protected $application;

    protected function setUp()
    {
        $this->base = $this->getKernel()
                ->getContainer()
                ->getParameter('mink.base_url');

        $this->session = $this->getMink()->getSession($this->sessionName);

        $this->initConsole();
    }

    /**
     * Initie la console.
     */
    protected function initConsole()
    {
        $kernel = $this->getKernel();
        $this->application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->application->setAutoExit(false);
        $this->application->setCatchExceptions(true);
    }

    /**
     * Execute la commande de la console.
     *
     * Runs the current application.
     *
     * @param string $command La comande
     * @param array  $options options de la commande
     *
     * @throws RuntimeException on error.
     *
     * @return true if everything went fine
     */
    protected function runConsole($command, array $options = array())
    {
        $options['-e'] = isset($options['-e']) ? $options['-e'] : 'test';
        $options['-q'] = isset($options['-q']) ? $options['-q'] : null;
        $options['-n'] = isset($options['-n']) ? $options['-n'] : true;
        $options = array_merge($options, array('command' => $command));

        $status = $this->application->run(new \Symfony\Component\Console\Input\ArrayInput($options));

        if ($status !== 0)
        {
            throw new \RuntimeException(sprintf('Une erreur est survenue lors d\'execution de la commande %s', $command));
        }

        return true;
    }

    /**
     * Genere la route en fonction de nom et parametres.
     *
     * @param string $route
     * @param array  $params
     *
     * @return string
     */
    protected function generateRoute($route, $params = array())
    {
        return $this->getContainer()->get('router')->generate($route, $params);
    }

    /**
     *
     * @param  string $route
     * @return type
     */
    protected function browse($route)
    {
        $this->session->visit($this->base . $route);

        return $this->session->getPage();
    }

    /**
     * @return \Symfony\Component\HttpKernel\Kernel
     */
    public static function getKernel()
    {
        if (null === static::$kernel)
        {
            static::$kernel = static::createKernel(array('environment' => 'test'));
        }
        if (!static::$kernel->getContainer())
        {
            static::$kernel->boot();
        }

        return static::$kernel;
    }

    /**
     * Recupere gestionaire des entités de doctrine.
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Gets doctrine repository.
     *
     * @param string $repository Repository name
     *
     * @return Doctrine\ORM\EntityRepository
     */
    protected function getRepository($repository)
    {
        return $this->getEm()->getRepository($repository);
    }

    /**
     * Translates the given message
     *
     * @param  string $id         The message id
     * @param  array  $parameters An array of parameters for the message
     * @param  string $domain     The domain for the message
     * @param  string $locale     The locale
     * @return string The translated string
     */
    protected function trans($id, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        return $this->getContainer()->get('translator')->trans($id, $parameters, $domain, $locale = null);
    }

    /**
     * Recupere l'utilisateur par son adresse mail.
     *
     * @param  string  $email Adresse mail de l'utilisateur.
     * @return User
     * @throws \RuntimeException
     */
    protected function getUserByEmail($email)
    {
        $dbUser = $this->getRepository('repoUserToDefine')->findOneBy(array('email' => $email));

        if (!($dbUser instanceof User))
        {
            throw new \RuntimeException(sprintf('Unable to retrieve User from database by email: %', $email));
        }

        return $dbUser;
    }

    public function iCheckTheRadioButtonWithValue($element, $value)
    {
        foreach ($this->session->getPage()->findAll('css', 'input[type="radio"][name="' . $element . '"]') as $radio)
        {
            if ($radio->getAttribute('value') == $value)
            {
                $radio->click();
                return true;
            }
        }
        return false;
    }

}
