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
	<br><br><br><br>
					<table border="1" style="width:100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Date</th>
								<th>Time in</th>
								<th>Remarks</th>
								<th>Time out</th>
								<th>Minutes Late</th>
								<th>Hours Rendered</th>
							</tr>
						</thead>
						<tbody>
							@foreach($attendance as $att)						
								<tr>
									<td><b>{{ $att->fname.' '.$att->mname.' '.$att->sname }}</b></td>						
									<td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y')  }}</td>
									<td>{{ \Carbon\Carbon::parse($att->time_in)->format('h:i:s A') }}</td>
									<td>{{ $att->stat_name }}</td>
								@if($att->time_out == '00:00:00')
									<td>---------------</td>
								@else
									<td>{{ \Carbon\Carbon::parse($att->time_out)->format('h:i:s A') }}</td>
								@endif						
								</tr>								
							@endforeach
						</tbody>
					</table>
</body>
</html>