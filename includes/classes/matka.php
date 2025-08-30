<?php class matka extends Wallet
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function userplay() {}

    public function winner() {}
    public function make_matka() {}

    public function user_history() {}
}
