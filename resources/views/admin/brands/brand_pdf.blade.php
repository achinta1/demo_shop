<style type="text/css">
	table td, table th{
		border:1px solid black;
	}
</style>
<div class="container">
	<table>
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Order Position</th>
			<th>Image</th>
			<th>Created Date Time</th>
			<th>Updated date Time</th>
			<th>Status</th>
		</tr>
		@foreach ($brands as $key => $brand)
		<tr>
			<td>{{ ++$key }}</td>
			<td>{{ $brand->name }}</td>
			<td>{{ $brand->order_position }}</td>
			<td>{{ $brand->image }}</td>
			<td>{{ $brand->created_at }}</td>
			<td>{{ $brand->updated_at }}</td>
			<td>{{ $brand->status }}</td>
		</tr>
		@endforeach
	</table>
</div>