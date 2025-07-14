<h2>Hello {{ $user->name }} 👋</h2>
<p>Your offer of <strong>{{ $offer->price }} EGP has been accepted for the property:</p>
<p><strong>{{ $property->title }}</strong></p>
<p>📅 Submission Date: {{ $offer->created_at->format('Y-m-d') }}</p>
<p>You can now log in to the platform and complete your reservation.</p>