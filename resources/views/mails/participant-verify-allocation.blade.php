<h1>Payment on Presentation System</h1>
<h2>This email is regarding allocation created</h2>
<p>Business Name: {{ $allocation->business->name }}</p>
<p>Participant Name: {{ $allocation->participant->name }}</p>
<p>Support Item: {{ $allocation->support_item }}</p>
<p>Support Category: {{ $allocation->support_item_name() }}</p>
<p>Price Charged: {{ '$' . $allocation->price_charged }}</p>
<p>Allocated Amount: {{ '$' . $allocation->allocated_amount }}</p>
<p>Start Date: {{ $allocation->start_date }}</p>
<p>End Date: {{ $allocation->end_date }}</p>
<hr>
<p>Click the link below to verify the allocation</p>
<p><a href="{{ route('verify', ['token' => strtr(base64_encode($allocation->id), '+/=', '-_,')]) }}">Verify Allocation</a></p>
<hr>
<p>Thank you</p>
