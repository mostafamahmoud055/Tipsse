<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Merchant Contract</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; line-height: 1.5; }
        h1, h2, h3 { color: #000; }
        .term { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Merchant Service Agreement</h1>
    <p>Contract Date: {{ date('F d, Y') }}</p>

    <p>Dear {{ $user->name }},</p>
    <p>This contract is between our company and <strong>{{ $user->business_type }}</strong> located at <strong>{{ auth()->user()->email }}</strong>.</p>

    <div>
        <p><strong>Contact Information:</strong></p>
        <p>Phone: {{ $user->phone }}</p>
    </div>

    <h2>Contract Terms:</h2>
    @foreach ($contractTerms as $index => $term)
        <div class="term">
            <h3>{{ $index + 1 }}. {{ $term['name'] }}</h3>
            <p>{{ $term['condition'] }}</p>
        </div>
    @endforeach

    <p>By accepting this contract, the Merchant agrees to be bound by all the terms and conditions outlined above.</p>
</body>
</html>
