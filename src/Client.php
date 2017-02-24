<?php
    class Client
    {
        private $name;
        private $id;

        function __construct($name,$id=null)
        {
            $this->name = $name;
            $this->id = $id;
        }
        function getNames()
        {
            return $this->name;
        }
        function getId()
        {
           return $this->id;
        }
        function save()
        {
           $GLOBALS['DB']->exec("INSERT INTO client (name) VALUES ('{$this->getNames()}')");
           $this->id = $GLOBALS['DB']->lastInsertId();

       }
        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM client;");
            $clients = array();
            foreach ($returned_clients as $client)
            {
                $client_name = $client['name'];
                $client_id = $client['id'];

                $new_client = new Client($client_name,$client_id);

                array_push($clients, $new_client);
            }
            return $clients;
        }
        static function find($search_id)
        {
            $found_name = null;
            $names = Client::getAll();
            foreach ($names as $name)
            {
                if ($search_id == $name->getId())
                {
                    $found_name = $name;
                }
            }
            return $found_name;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM client;");
        }

    }





?>
