<?php

    class Controllers{

        public $model;
        public $views;
        
        public function __construct()
        {
            $this->views = new Views();
            $this->loadModel();
        }

        public function loadModel()
		{
            $model = get_class($this)."Model";
            $routClass = "Models/".$model.".php"; // Models/HomeModel.php
            if(file_exists($routClass)){
				require_once($routClass);
				$this->model = new $model();
			}
        }

    }

?>