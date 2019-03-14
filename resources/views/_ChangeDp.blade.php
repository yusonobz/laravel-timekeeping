		    <div class="modal fade" id="changeDP" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		   <div class="modal-dialog modalBox">
		     <div class="modal-content">
		       <div class="modal-header headerTitle">
		         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button>
		         <h4 class="modal-title" id="lineModalLabel">Change Display Picture</h4>
		       </div>
		       <div class="modal-body">
						<!-- content-->	
					{!! Form::open(array('url'=>'purpleBugTK/upload','role'=>'form','method'=>'POST', 'files'=>true)) !!}
						 <input name="id" type="hidden">
							<div class="form-group">
							   {!! Form::file('image') !!}	
							</div>

				
		       </div>
		       <div class="modal-footer">
      {!! Form::submit('Submit', array('class'=>'ChangeDPBtn')) !!}
		         <button type="button" class="btn ChangePassBtn" data-dismiss="modal">Close</button>
		       
		       </div>
		       {!! Form::close() !!}
		     </div>
		     		  </div>
		 </div>