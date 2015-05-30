<?php
	class Assigment
	{
		public $Size=0;
		public $Materie="";
		public $Dificultate="";
		public $Title="";
		public $Due_Time="";
		public $Nota="0";

		public function __construct($Materie,$Size,$Dificultate,$Title,$Due_Time)
		{
			$this->Title=$Title;
			$this->Due_Time=$Due_Time;
			$this->Size=$Size;
			$this->Materie=$Materie;
			$this->Dificultate=$Dificultate;
		}

		public function setNota($nota)
		{
			$this->Nota=$nota;
		}
		public function Afisare()
		{
			echo "<u><b>Assigment</b></u><br>";
			echo "Materie: ".$this->Materie."<br>";
			echo "Titlu: ".$this->Title."<br>";
			echo "Dificultate: ".$this->Dificultate."<br>";
			echo "Dimensiune: ".$this->Size."<br>";
			echo "Data Predarii: ".$this->Due_Time."<br>";
			echo "Nota: ".$this->Nota."<br>";
		}
	}

	class Test
	{
		public $Materie="";
		public $info="";
		public $Due_Time="";
		public $Nota="";

		public function __construct($Materie,$Due_Time)
		{
			$this->Materie=$Materie;
			$this->Due_Time=$Due_Time;
		}

		public function setNota($nota)
		{
			$this->Nota=$nota;
		}
		public function addInfo($Info)
		{
			$this->info=$Info; //trebuie gandita
		}
		public function Afisare()
		{
			echo "<u><b>Test</b></u><br>";
			echo "Materie: ".$this->Materie."<br>";
			echo "Data: ".$this->Due_Time."<br>";
			echo "Nota: ".$this->Nota."<br>";
		}
	}

	class Tema
	{
		public $Materie="";
		public $info="";
		public $Content="";
		public $Due_Time="";
		public $Nota="";

		public function __construct($Materie,$Due_Time,$Content)
		{
			$this->Materie=$Materie;
			$this->Due_Time=$Due_Time;
			$this->Content=$Content;
		}
		public function setNota($Nota)
		{
			$this->Nota=$Nota;
		}
		public function setInfo($Info)
		{
			$this->info=$Info; //trebuie gandita
		}
		public function Afisare()
		{
			echo "<u><b>Tema</b></u><br>";
			echo "Materie: ".$this->Materie."<br>";
			echo "Data: ".$this->Due_Time."<br>";
			echo "<b>Cerinta</b>:"."<br>".$this->Content."<br>";
			echo "Nota: ".$this->Nota."<br>";
		}
	}
?>