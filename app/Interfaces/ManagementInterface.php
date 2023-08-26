<?php
    namespace App\Interfaces;

    interface ManagementInterface {
        /* Add an enity */
        public function add();

        /* Delete an enity */
        public function delete();

        /* Edit an enity */
        public function edit();

        /* Info about an enity */
        public function info();

        /* Index page of entity */
        public function index();
    }
?>
