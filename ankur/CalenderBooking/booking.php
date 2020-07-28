<?php

class booking{
	private $dbh;
	private $bookingsTableName ='Book';


	public function __construct($database,$host,$username,$user_password){
		try{
			$this->dbh =new PDO(sprintf('mysql:host=%s;dbname=%s',$host,$database),$username,$user_password);

		}

		catch(PDOexception $e){
			die($e->getMessage());
		}

	}


	public function index(){
		$statement =$this->dbh->query('select* from' . $this->bookingsTableName);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

public function insert_booking(DateTimeImmutable $bookingDate){
	$statement =$this->dbh->prepare(
		'INSERT INTO ' . $this->bookingsTableName . ' (booking_date) values (:bookingDate)');


	if(false==$statement){
		throw new Exception('Invalid prepare statement');

	}

	if(false===$statement->execute([':bookingDate' => $bookingDate->format('Y-m-d'),])){
		throw new Exception(implode(' ',$statement->errorInfo()));
	}
}


public function deelete($user_id){
	$statement =$this->dbh->prepare(
		'DELETE from ' . $this->bookingsTableName . 'where user_id =:user_id');

	if(false===$statement){
		throw new Exception('Invalid prepare statement');
	}

	if(false === $statement->execute([':user_id' => $user_id])){
		throw new Exception(implode(' ' ,$statement->errorInfo()));
	}
}




}