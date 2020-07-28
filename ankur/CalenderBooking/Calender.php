<?php
class Calender{

public function __construct(){
	$this->n_ref =htmlentities($_SERVER['PHP_SELF']);
}

public $box ='';
protected $a =array();

private $day_array =array("Monday","Tuesday"," Wednesday","Thursday","Friday","Saturday","Sunday");
private $current_year =0;
private $current_month =0;

private $current_day =0;
private $current_date =null;
private daysInMonth =0;

private $sundayFirst =true;
private $n_ref =null;


public function check_type($type,$ob){
	$this->a[$type][] =$ob;

}

public function notify($type){
	if(isset($this->a[$type])){
		foreach ($this->a[$type] as $ob) {

			# code...
			$ob->update($this);
		}
	}
}


public function getCurrentDate(){
	return $this->currentDate;
}

public function setSundayFirst($bool =true){
	$this->sundayFirst =$bool;
}


public function show($month=null,$year =null,$attributes =false){
	if(null==$year && isset($_GET['year'])){
		$year =$_GET['year'];

	}
	else if(null==$year){
		$year =date("Y",time())
	}

	if(null ==$month && isset($_GET['month'])){
		$month =$_GET['month'];

	}

	else if(null ==$month){
		$month =date("m",time());
	}

	$this->currentYear =$year;
	$this->currentMonth =$month;
	$this->daysInMonth =$this->_daysInMonth($month,$year);

	$content ='<div id ="calender">' . '<div class ="box">' .
	$this->_createNavi() .
	'</div>' . 
	'<div class ="box-content">' .
	'<div class ="label">' . $this->_createLabels() . '</ul>';

	$content .= '<div class="clear"></div>';

	$content .= '<ul class="dates">';

	for($i =0;$i<$this->_weeksInMonth($month,$year);$i++){
		for($j =1;$j<=7;$j++){
			$content .= $this->_showDay($i*7 + $j,$attributes);
		}
	}


	$content .='</ul>';
	$content .='<div class ="clear"</div>';
	$content .= '</div>';
	$content .= '</div>';

	return $content;
}

private function showDay($boxNumber,$attributes =false){
	if($this->currentDay ==0){
		$firstDayOfTheWeak  =date('N',strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));

		if($this->sundayFirst){
			if($firstDayOfTheWeak==7){
				$firstDayOfTheWeak =1;

			}

			else{
				$firstDayOfTheWeak++;
			}
		}

		if(intval($boxNumber)==intval($firstDayOfTheWeak)){
			$this->currentDay =1;
		}
	}


	if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {
            $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
            $boxContent = $this->_createboxContent($attributes);
            $this->currentDay++;
        } else {
            $this->currentDate = null;
            $boxContent = null;
        }

                return '<li id="li-' . $this->currentDate . '" class="' . ($boxNumber % 7 == 1 ? ' start ' : ($boxNumber % 7 == 0 ? ' end ' : ' ')) .
            ($boxContent == null ? 'mask' : '') . '">' . $boxContent . '</li>';
}


private function create_Navigation(){
	$nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth) + 1;
        $nextYear = $this->currentMonth == 12 ? intval($this->currentYear) + 1 : $this->currentYear;
 
        $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth) - 1;
        $preYear = $this->currentMonth == 1 ? intval($this->currentYear) - 1 : $this->currentYear;



        return
            '<div class="header">' .
            '<a class="prev" href="' . $this->n_ref . '?month=' . sprintf('%02d', $preMonth) . '&year=' . $preYear . '">Prev</a>' .
            '<span class="title">' . date('Y M', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')) . '</span>' .
            '<a class="next" href="' . $this->n_ref . '?month=' . sprintf("%02d", $nextMonth) . '&year=' . $nextYear . '">Next</a>' .
            '</div>';
}

private function _createLabels()
    {
        if ($this->sundayFirst) {
            $temp = $this->dayLabels[0];
            for ($i = 1; $i < sizeof($this->dayLabels); $i++) {
                $tmp = $this->dayLabels[$i];
                $this->dayLabels[$i] = $temp;
                $temp = $tmp;
            }
            $this->dayLabels[0] = $temp;
        }
 
 
        $content = '';
        foreach ($this->dayLabels as $index => $label) {
            $content .= '<li class="' . ($label == 6 ? 'end title' : 'start title') . ' title">' . $label . '</li>';
        }
 
        return $content;
    }

    private function _createboxContent($setting = false)
    {
        $this->boxContent = '';
 
        $this->boxContent = $this->currentDay;
 
       
        $this->notify('showCell');
 
        return $this->boxContent;
    }

private function weeksInMonth($month = null, $year = null)
    {
        if (null == ($year))
            $year = date("Y", time());
 
        if (null == ($month))
            $month = date("m", time());
 
        // find number of weeks in this month
        $daysInMonths = $this->_daysInMonth($month, $year);
 
        $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);
        $monthEndingDay = date('N', strtotime($year . '-' . $month . '-' . $daysInMonths));
        $monthStartDay = date('N', strtotime($year . '-' . $month . '-01'));
        $monthEndingDay == 7 ? $monthEndingDay = 0 : '';
        $monthStartDay == 7 ? $monthStartDay = 0 : '';
 
        if ($monthEndingDay < $monthStartDay) {
            $numOfweeks++;
        }
        return $numOfweeks;
 
    }


     private function daysInMonth($month = null, $year = null)
    {
        if (null == ($year))
            $year = date("Y", time());
 
        if (null == ($month))
            $month = date("m", time());
 
        return date('t', strtotime($year . '-' . $month . '-01'));
    }

    
}