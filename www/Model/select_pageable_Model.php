<?php
class select_pageable_Model
{
	function run($i,$n)
	{
		try {
			$first = $i*$n-$n;
		
			$r = $this->obj->connect->query('SELECT * FROM '.$this->obj->orm_object.' ORDER BY '.$this->obj->orm_sequence." LIMIT $first,$n");
			for ($this->obj->orm_entity=array(); $row=$r->fetch(PDO::FETCH_ASSOC); $this->obj->orm_entity[]=$row);
					
			$rcCmd = $this->obj->connect->query('SELECT COUNT(*) FROM '.$this->obj->orm_object);
			$rc = $rcCmd->fetchColumn(); 
			$pnst = 3;
			$pnen = 3;
			$pn = $pnst + $pnen;
			$pgcnt = ceil($rc/$n);
			
			$this->obj->orm_pageable_array = array();
			if ($rc/$n > $pn) {
				$page_array = array();
				
				for($j = 1;$j<=$pgcnt;$j++) {
					if ($i == $j) {
						if ($j>1) $page_array[$j-1] = $j-1;
						$page_array[$j] = $j;
						if ($j<$pgcnt)$page_array[$j+1] = $j+1;
						continue;
					}
					if ($j<=$pnst) {$page_array[$j] = $j;continue;}
					if ($j>$pgcnt-$pnen) {$page_array[$j] = $j;}
				}
				
				$pagebuf = 1;
				foreach($page_array as $page => $name) {
					if ($page - $pagebuf > 1) $this->obj->orm_pageable_array[round(($pagebuf+$page)/2)] = '...';
					$this->obj->orm_pageable_array[$page] = $name;
					$pagebuf = $page;
				}
			}
			else {
				for ($j = 1;$j<=$pgcnt;$j++) {
					$this->obj->orm_pageable_array[$j] = $j;
				}
			};			
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
		
		return $this->obj->orm_entity;
	}
}
?>