<html>
<style>
head, body {
            font-family: 'Courier New';

           }

 th, td {
 			text-align:center;
 		}
</style>
<head><img src="{{ asset('pblogo.png') }}"><br>
PurpleBug Inc.<br>
Unit 806 Antel 2000 Corporate Center, Valero Street, <br>
Salcedo Village, Makati City<br>
Tel +63 (2) 551-0986 +63 (2) 7899150<br>                  
Fax +63 (2) 789 9001<br>
www.purplebug.net<br>
</head>
<body>
	<br><br>
	<br><br>
	<h2 align="center">Daily Time Record</h2>
					<table border="1" style="width:100%">
						<thead>
							<tr>
								<th>Date</th>
								<th>Time in</th>
								<th>Time out</th>
								<th>Remarks</th>

							<!-- 	<th>Hours Rendered</th> -->
							</tr>
						</thead>
						<tbody>
						@foreach($attendance as $att)
						<?php $name = $att->fname . " " . $att->sname;
						$position = $att->position_description;
						$dep = $att->dep_desc ;
						 ?>
						<tr>			
							<td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
							<td>{{ \Carbon\Carbon::parse($att->time_in)->format('h:i:s A')  }}</td>
							<td>{{ \Carbon\Carbon::parse($att->time_out)->format('h:i:s A') }}</td>
							<td>{{ $att->stat_name }}</td>

						</tr>
							@endforeach
						</tbody>
					</table>
<br><br>
<div style="margin-left:20pt;">	
To:&nbsp;<b><?php echo $name ?></b><br>
<i style="margin-left:15pt;"><?php echo $position ?></i><br>
<i style="margin-left:15pt;"><?php echo $dep ?></i>
</div>
<div style="float:right; margin-bottom:300px;margin-left:750pt;">	
Noted By:<br><br><br>
_________________________<br>
   <b>Ms. Jovelyn Salcedo</b><br>
<i>HR & Administrative Officer</i>
<!-- <pre><b>Total Hours Rendered: {{ $count }} hours</b></pre> -->
</div>


</body>

</html>