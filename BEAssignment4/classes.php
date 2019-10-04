<?php
	
	class JSON { 
		public $data = array(); 
		public $error = "";  
		
		
		function save_file($file_name, $new_data) {
			try{
				file_put_contents($file_name, json_encode($new_data)); 
			}
			catch(Exception $e) {
				$this->error = $e->getMessage(); 
			}
		}
		function get_file($file_name) { 
			try {
				$this->data = json_decode(file_get_contents($file_name)); 
			}
			catch (Exception $e) {
				$this->error = $e->getMessage(); 
			}
		}
		function add($key, $arr = array()) {
			try {
				$this->data->{$key} = $arr; 
			}
			catch (Exception $e) {
				$this->error = $e->getMessage(); 
			}
		}
		function update($primary_key, $new_data = array()) { 
			try {
				foreach ($this->data as $key => $value) {
					if ($primary_key == $key) {
						$this->data->{$key} = $new_data; 
					}
				}
			}
			catch(Exception $e) {
				$this->error = $e->getMessage(); 
			}
			
		}
		function delete($primary_key) { 
			try {
				foreach ($this->data as $key => $value) {
					if ($primary_key == $key) {
						unset($this->data->{$key}); 
					}
				}
			}
			catch (Exception $e) {
				$this->error = $e->getMessage(); 
			}
		}
		function debug_print() {
			echo "<pre>"; 
			print_r($this->data); 
			echo "</pre>"; 
		}
	}
	
	class BnB extends JSON {

		protected $Title; 
		protected $Bedrooms; 
		protected $Beds; 
		protected $Baths; 
		protected $Description; 
		protected $Images = array(); 
		protected $Superhosted = false; 
		
		function __construct() {
			$this->get_file("bnbs.json"); 
		}
		function set_bnb($primary_key) {
			foreach ($this->data as $key => $value) {
				if ($key == $primary_key) {
					$this->Title = $this->data->$key->Title; 
					$this->Bedrooms = $this->data->$key->Bedrooms; 
					$this->Beds = $this->data->$key->Beds; 
					$this->Baths = $this->data->$key->Baths; 
					$this->Description = $this->data->$key->Description; 
					$this->Superhosted = $this->data->$key->Superhosted; 
					$this->Images = $this->data->$key->Images; 
				}
			}
		}
		function get_Title() {
			return $this->Title; 
		}
		function get_Bedrooms() {
			return $this->Bedrooms; 
		}
		function get_Beds() {
			return $this->Beds; 
		}
		function get_Baths() {
			return $this->Baths; 
		}
		function get_Description() {
			return $this->Description; 
		}
		function get_Images() {
			return $this->Images; 
		}
		function get_Superhosted() {
			return $this->Superhosted; 
		}
		function set_Title($value) {
			if (is_string($value)) {
				$this->Title = htmlspecialchars($value); 
			} 
			else {
				throw new Exception("Titles must be of type string", 1);
			}
		}
		function set_Bedrooms($num) {
			if (is_int($num)) {
				$this->Bedrooms = $num; 
			}
			else{
				throw new Exception("Bedrooms must be of type int", 1);
			}
		}
		function set_Beds($num) {
			if (is_int($num) && $num > 0) {
				$this->Beds = $num; 
			}
			else {
				throw new Exception("Beds must be of type int and greater than 0", 1);
			}
		}
		function set_Baths($num) {
			if (is_int($num)) {
				$this->Baths = $num; 
			}
			else {
				throw new Exception("Baths must be of type int", 1);
			}
		}
		function set_Description($value) {
			if (is_string($value)) {
				$this->Description = htmlspecialchars($value); 
			}
			else {
				throw new Exception("Description must be of type string", 1);
			}
		}
		function save_Image($file) {
			// only upload up to 3 files of type image/jpeg  
				if ($file["type"] == "image/jpeg") { 
					$new_file_name = uniqid(); 
					move_uploaded_file($file["tmp_name"], dirname(__FILE__)."\\img\\".$new_file_name.".jpg");
					$this->Images[] = $new_file_name;  
			    }
			    else {
			    	throw new Exception("Files must be of type jpeg", 1);
			    	
			    }
		}
		function delete_Image($name) {
			array_splice($this->Images, array_search($name, $this->Images));  
			unlink(dirname(__FILE__)."\\img\\".$name.".jpg");
		}
		function set_Superhosted($bool) {
			if (is_bool($bool)) {
				$this->Superhosted = $bool; 
			}
			else {
				throw new Exception("Superhosted must be of type bool", 1);
				
			}
		}
		function save_new() {
			$this->add(count((array) $this->data) + 1, array(
				"Title" => $this->Title,
				"Bedrooms" => $this->Bedrooms, 
				"Beds" => $this->Beds,
				"Baths" => $this->Baths,
				"Description" => $this->Description, 
				"Images" => $this->Images, 
				"Superhosted" => $this->Superhosted
			)); 
			$this->save_file("bnbs.json", $this->data); 
		}

	}
 
?>