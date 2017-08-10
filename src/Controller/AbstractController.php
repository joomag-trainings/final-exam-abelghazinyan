<?php

    namespace Controller;

    use Slim\Container;

    /**
     * Class AbstractController
     * @package Core
     */
    abstract class AbstractController
    {
        protected $container;

        /**
         * AbstractController constructor.
         * @param Container $container
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
        }

    }