<form action="{{ url('admin/customer/'.$customer->id.'/edit') }}" method="post">

<div class="form-group">
	<label>Username</label>
	<input type="text" class="form-control" name="username" value="{{ $customer->username }}" required>
</div>

<div class="form-group">
	<label>Password</label>
	<input type="password" class="form-control" name="password">
</div>

<div class="form-group">
	<label>First Name</label>
	<input type="text" class="form-control" name="firstname" value="{{ $customer->firstname }}" required>
</div>

<div class="form-group">
	<label>Last Name</label>
	<input type="text" class="form-control" name="lastname" value="{{ $customer->lastname }}" required>
</div>

<div class="form-group">
	<label>E-mail</label>
	<input type="email" class="form-control" name="email" value="{{ $customer->email }}" required>
</div>

<div class="form-group">
	<label>Phone Number</label>
	<input type="text" class="form-control" name="phone_number" value="{{ $customer->phone_number }}" required>
</div>

<div class="form-group">
	<label>Unique ID</label>
	<input type="text" class="form-control" name="unique_id" value="{{ $customer->unique_id }}" required>
</div>

<div class="form-group text-right">
    <input type="submit" class="btn btn-primary" value="Edit Customer">
</div>

</form>
