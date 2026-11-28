<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entry</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>

<body>
    <header>
        <div class="container-header">
            <div class="headerRight">
                <h1>Edit Journal</h1>
            </div>
            <div class="headerLeft">
                <a href="homepage" class="active">Home</a>
                <a href="">About</a>
                <a href="">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="title-center">
            <div class="title">
                <h1>Edit Journal Entry</h1>
            </div>
        </div>

        <div class="entry-box">
            <div class="date">
                <p>Date</p>
                <input type="date" value="{{ $journal->date }}" name="date" readonly>
            </div>
            <div class="title">
                <p>Title</p>
                <input type="text" name="title" placeholder="Enter title for your journal entry..."
                    value="{{ $journal->title }}" readonly>
            </div>
            <div class="mood">
                <p>Mood</p>
                <select name="mood" id="mood" value="{{ $journal->mood }}" disabled>
                    <option value="Happy" {{ $journal->mood == 'Happy' ? 'selected' : '' }}>Happy
                    </option>
                    <option value="Sad" {{ $journal->mood == 'Sad' ? 'selected' : '' }}>Sad</option>
                    <option value="Excited" {{ $journal->mood == 'Excited' ? 'selected' : '' }}>Excited
                    </option>
                    <option value="Disappointed" {{ $journal->mood == 'Disappointed' ? 'selected' : '' }}>Disappointed
                    </option>
                    <option value="Angry" {{ $journal->mood == 'Angry' ? 'selected' : '' }}>Angry
                    </option>
                    <option value="In Love" {{ $journal->mood == 'In Love' ? 'selected' : '' }}>In
                        Love</option>
                </select>
            </div>
            <div class="description">
                <p>Journal Entry</p>
                <textarea name="description" id="description" rows="8" cols="108" placeholder="Write about your day..."
                    readonly>{{ $journal->description }}</textarea>
            </div>
            <div class="button">
                <button type="button" onclick="window.location='{{ route('journals.index') }}'">Cancel</button>
            </div>
        </div>
    </div>
</body>

</html>
