		    <div class="modal fade" id="aw" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		   <div class="modal-dialog modalBox">
		     <div class="modal-content">
		       <div class="modal-header headerTitle">
		         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button>
		         <h4 class="modal-title" id="lineModalLabel">Change Password</h4>
		       </div>
		       <div class="modal-body">
						<!-- content-->	
						{!!Form::open(['url' => '/changePassword', 'role' => 'form', 'method' => 'POST']) !!}
						 <input name="id" type="hidden">
							<div class="form-group">
								{!! Form::label('newpass', 'New Password:') !!}
								<input type="password" class="form-control" id="pwd" name="pwd" placeholder="New Password" style="border-radius:7pt;">		
							</div>
							<div class="form-group">
								{!! Form::label('confirmpass', 'Confirm Password:') !!}
								<input type="password" class="form-control" id="confirmpwd" name="confirmpwd" placeholder="Confirm Password" style="border-radius:7pt;">		
							</div>
				
		       </div>
		       <div class="modal-footer">
		       	 <button class="btn ChangePassBtn">Save</button>
		         <button type="button" class="btn ChangePassBtn" data-dismiss="modal">Close</button>
		       
		       </div>
		       {!! Form::close() !!}
		     </div>
		     		  </div>
		 </div>