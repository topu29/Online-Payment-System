<?php
// write dao object for each class
include_once './common/class.common.php';
include_once './common/class.common.product.php';
include_once './util/class.util.php';

Class Create_ProductDAO{

	private $_DB;
	private $_Cat;

	function Create_ProductDAO(){

		$this->_DB = DBUtil::getInstance();
	

	}


	public function getAllProductCategorys(){

		$ProductCategoryList = array();

		$this->_DB->doQuery("SELECT * FROM tbl_product_category order by Category ASC");

		$rows = $this->_DB->getAllRows();

		for($i = 0; $i < sizeof($rows); $i++) {
			$row = $rows[$i];
			$this->_ProductCategory = new ProductCategory();

		    $this->_ProductCategory->setID ( $row['ID']);
		    $this->_ProductCategory->setCategory( $row['Category'] );

		    $ProductCategoryList[]=$this->_ProductCategory;

		    }

		
		$Result = new Result();
		$Result->setIsSuccess(1);
		$Result->setResultObject($ProductCategoryList);

		return $Result;
	}

	public function createProduct($create_product){

		$ID=$create_product->getID();
		$Name=$create_product->getName();
		$Category=$create_product->getCategoryID();
		$Price=$create_product->getPrice();
		$Credit=$create_product->getOfferedCredit();
		$Picture=$create_product->getPicture();

		
		//$Creator=$_SESSION["globalUser"]->getID ();

		$SQL = "INSERT INTO tbl_products(ID,Name,CategoryID,Price,OfferedCredit,PictureAddress) 
				VALUES('$ID','$Name','$Category','$Price','$Credit','$Picture')";

		$SQL = $this->_DB->doQuery($SQL);		
		
	 	$Result = new Result();
		$Result->setIsSuccess(1);
		$Result->setResultObject($SQL);

		

		return $Result;
	}

		public function editProduct($Product){
		
		
		$SQL = "SELECT * FROM tbl_products WHERE ID='".$Product->getID()."'";
		$this->_DB->doQuery($SQL);

		//reading the top row for this Product from the database
		$row = $this->_DB->getTopRow();

		$this->_Product= new Products();

		//preparing the Product object
	    $this->_Product->setID ( $row['ID'] );
	    $this->_Product->setName( $row['Name'] );
	    $this->_Product->setCategoryID( $row['CategoryID'] );
		$this->_Product->setPrice( $row['Price'] );
		$this->_Product->setOfferedCredit( $row['OfferedCredit'] );



	 	$Result = new Result();
		$Result->setIsSuccess(1);
		$Result->setResultObject($this->_Product);

		return $Result;
	}

	//update a Product object
	public function updateProduct($Product){
				
		$pic="";
		if (strcmp($Product->getPicture(), $pic)!=0) {
			$SQL = "UPDATE tbl_products SET Name='".$Product->getName()."',
				CategoryID = '".$Product->getCategoryID()."',
				Price='".$Product->getPrice()."',
				OfferedCredit='".$Product->getOfferedCredit()."',
				PictureAddress='".$Product->getPicture()."'
				WHERE ID='".$Product->getID()."'";
		}
		//this is for updating a product if new picture is not added
		else
		{
			$SQL = "UPDATE tbl_products SET Name='".$Product->getName()."',
				CategoryID = '".$Product->getCategoryID()."',
				Price='".$Product->getPrice()."',
				OfferedCredit='".$Product->getOfferedCredit()."'
				WHERE ID='".$Product->getID()."'";
		}

		//$this->_DB->getConnection()->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
		$SQL = $this->_DB->doQuery($SQL);

	 	$Result = new Result();
		$Result->setIsSuccess(1);
		$Result->setResultObject($SQL);

		return $Result;




	}

	//delete a Product based on its id of the database
	public function deleteProduct($Product){


		$SQL = "DELETE from tbl_products where ID ='".$Product->getID()."'";
	
		$SQL = $this->_DB->doQuery($SQL);

	 	$Result = new Result();
		$Result->setIsSuccess(1);
		$Result->setResultObject($SQL);

		return $Result;

	}

	




	

	}


	


echo '<br> log:: exit the class.create_productdao.php';

?>