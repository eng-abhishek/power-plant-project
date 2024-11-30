      <div class="modal-header">
      	<h5 class="modal-title" id="exampleModalLabel">Edit Schedule</h5>
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
      		<span aria-hidden="true">&times;</span>
      	</button>
      </div>
      <div class="modal-body">
      	{{ Form::model($record, array('route' => ['schedule.update', $record->id], 'id'=>'edit-schedule-form', 'class' => 'm-form')) }}
      	@method('PUT')
      	<div class="m-portlet__body">	
      		<div class="m-form__section m-form__section--first">


      			<div class="form-group m-form__group row">
      				<label class="col-lg-3 col-form-label">Select Plan:</label>
      				<div class="col-lg-6">
      					<select class="form-control" name="plant_id">
      						<option value="">--select--</option>
      						@if(isset(($plants)))
      						@foreach($plants as $value)
      						<option {{($record->plant_id == $value->id) ? 'selected' : '' }} value="{{$value->id}}">{{$value->name}}</option>
      						@endforeach
      						@endif
      					</select>
      					@error('plant_id')
      					<span class="invalid-feedback" role="alert">
      						<strong>{{ $message }}</strong>
      					</span>
      					@enderror
      				</div>
      			</div>		              

      			<div class="form-group m-form__group row">
      				<label class="col-lg-3 col-form-label">Date:</label>
      				<div class="col-lg-6">
      					<input type="date" name="date" value="{{$record->date ?? ''}}" class="form-control">
      					@error('date')
      					<span class="invalid-feedback" role="alert">
      						<strong>{{ $message }}</strong>
      					</span>
      					@enderror
      				</div>
      			</div>

      			<div class="form-group m-form__group row">
      				<label class="col-lg-3 col-form-label">Power:</label>
      				<div class="col-lg-6">
      					{{ Form::text('scheduled_power', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter power', 'autocomplete' => 'off', 'autofocus')) }}

      					@error('slug')
      					<span class="invalid-feedback" role="alert">
      						<strong>{{ $message }}</strong>
      					</span>
      					@enderror
      				</div>
      			</div>

      			<div class="form-group m-form__group row">
      				<label class="col-lg-3 col-form-label">Number of Blocks:</label>
      				<div class="col-lg-6">
      					<div class="row">
      						<div class="col-lg-9">
      							<input type="range" name="block_range" class="form-control-range py-3" min="1" max="96" id="block_range" value="96">
      						</div>
      						<div class="col-lg-3">
      							<span class="input-group-text ml-3" id="block_text">96</span>
      						</div>
      					</div>
      					@error('block_range')
      					<span class="invalid-feedback" role="alert">
      						<strong>{{ $message }}</strong>
      					</span>
      					@enderror
      				</div>
      			</div>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
      {{ Form::close() }}
      		</div>
      	</div>

      </div>
      <div class="modal-footer">
      	
      </div>
