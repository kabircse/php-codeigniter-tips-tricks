//Dependency injection is a big word for "I have some more parameters in my constructor".

//It's what you did before the awfull Singleton wave when you did not like globals :

class User {
    private $_db;
    function __construct($db) {
        $this->_db = $db;
    }
}

$db   = new Db();
$user = new User($db);

//Now, the trick is to use a single class to manage your dependencies, something like that :

class DependencyContainer 
{
    private _instances = array();
    private _params = array();

    public function __construct($params)
    {
        $this->_params = $params;
    }

    public function getDb()
    {
        if (empty($this->_instances['db']) 
            || !is_a($this->_instances['db'], 'PDO')
        ) {
            $this->_instances['db'] = new PDO(
                $this->_params['dsn'],
                $this->params['dbUser'], 
                $this->params['dbPwd']
            );
        }
        return $this->_instances['db'];
    }
}

class User
{
    private $_db;
    public function __construct(DependencyContainer $di)
    {
         $this->_db = $di->getDb();
    }
}

$dependencies = new DependencyContainer($someParams);
$user = new User($dependencies);
/*

You must think you just another class and more complexity. But, your user class may need something to log messages like lot of other classes. Just add a getMessageHandler function to your dependency container, and some $this->_messages = $di->getMessageHandler() to your user class. Nothing to change in the rest of your code.
*/