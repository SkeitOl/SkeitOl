<?



/*Товары*/
$products=array();
$lines = file('http://prazdniksnab.com/Store.txt');
foreach ($lines as $key => $value) {
	$ar_product=explode('@', $value);

	$products[trim($ar_product[1])]=array(
		'ID'=>trim($ar_product[1]),
		'GROUP'=>trim($ar_product[0]),
		'NAME'=>trim($ar_product[3]),
		'PRICE'=>trim($ar_product[7]),
		'SYMBOL_NAME'=>trim($ar_product[2]),
	);
}


/*Лиды*/
$lines = file('http://prazdniksnab.com/leads.txt');
$leads=array();
$il=0;
foreach ($lines as $key => $value) {
	$ar_lead=explode('@END@', $value);
	if(count($ar_lead)>2){
		foreach ($ar_lead as $k=>$val){
			$t=explode('=',trim($val));

			if(count($t)==2){
				$key_t=trim(strip_tags($t[0]));
				$val_t=trim($t[1]);
				$leads[$il][$key_t]=$val_t;

				if($key_t=='Корзина'){
					$val_t=preg_replace("/\s+\r\n/","", $val_t);
					$split_card=explode(',',$val_t);
					$temp_card=array();
					foreach ($split_card as $key_t => $card_val) {
						$test_card=explode(':',trim($card_val));

						$test_product=explode('_',trim($test_card[0]));

						if($test_product[1] && $test_card[1])
							$temp_card[]=array(
								'ID'=>trim($test_product[1]),
								'COUNT'=>trim($test_card[1])
							);

					}
					if($temp_card){
						$leads[$il]['CARD']=$temp_card;

						$sum=0;
						foreach ($temp_card as $k_t => $pr) {
							$sum+=((int)$pr['COUNT'])*((float)$products[$pr['ID']]['PRICE']);
						}

						$leads[$il]['SUM']=$sum;
					}
				}
			}
		}
		$il++;
	}
}



function PrintLeads($leads){
	?>
	<table class="lead_t">
		<thead>
		</thead>
		<tbody>
			<?
			foreach ($leads as $key => $lead) {
				?>
					<tr>
						<td><?=$key?></td>
						<td><?=$lead['LEAD_DATE']?></td>
						<td><?=$lead['Имя']?></td>
						<td><?=number_format($lead['SUM'], 2, ',', ' ')?></td>
						<td><?=$lead['Телефон']?></td>
						<td><?=$lead['Адрес']?></td>
						<td><?=$lead['Корзина с описанием']?></td>
					</tr>
				<?
			}
			?>
		</tbody>
	</table>
	<?
}

function getLeadToday($leads){
	$leads_today=array();
	

	$date_now_start=mktime(0,0,0,date("n"),date("j"),date("Y"));
	$date_now_end=mktime(23,59,59,date("n"),date("j"),date("Y"));

	$sum=0;
	foreach ($leads as $key => $lead) {
		$d_l=strtotime($lead['LEAD_DATE']);
		if($d_l>=$date_now_start && $d_l<=$date_now_end){
			$leads_today[]=$lead;
			$sum+=$lead['SUM'];
		}
	}
?><div style="height:400px;overflow:auto;padding-left:15px"><?
	PrintLeads($leads_today);?></div><?
	?><br><p>Заказов на сумму: <strong><?=number_format($sum, 2, ',', ' ')?> руб.</strong></p><?

	$lead_one=array();


}

?>
<pre><?//print_r($leads)?></pre>
<script src="https://www.google.com/jsapi"></script>
<style>
.lead_t{
border-collapse: collapse;}
	.lead_t td{
		padding:5px;
		border:1px solid #ccc;
	}
	.lead_t tr:hover{
		background:#ddd;
	}
</style>
<div style="">
	<h2>Лиды</h2>
	<div style="height:400px;overflow:auto;padding-left:15px">
		<?PrintLeads($leads);?>
	</div>
	<h2>Заказы сегодня <?echo date('Y m d')?></h2>
	<div>
		<?getLeadToday($leads);?>
	</div>
	
		
	
	<div id="air" style="width: 500px; height: 400px;"></div>
</div>



  <script>
   google.load("visualization", "1", {packages:["corechart"]});
   google.setOnLoadCallback(drawChart);
   function drawChart() {
    var data = google.visualization.arrayToDataTable([
     ['Газ', 'Объём'],
     ['Азот',     10],
     ['Кислород', 20],
     ['Аргон',    5],
     ['Углекислый газ', 50]
    ]);
    var options = {
     title: 'Состав воздуха',
     is3D: true,
     pieResidueSliceLabel: 'Остальное'
    };
    var chart = new google.visualization.PieChart(document.getElementById('air'));
     chart.draw(data, options);
   }
  </script>