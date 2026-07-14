<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>

<body>
    <header>
        <div class="container-header">
            <div class="headerRight">
                <h1>My Journal</h1>
            </div>
            <div class="headerLeft">
                <a href="homepage" class="active">Home</a>
                <a href="">About</a>
                <a href="">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <main>
            <section class="dashoard-header">
                <div class="welcome-message">
                    <h2>Welcome back, Hasnieza!</h2>
                    <a href="{{ route('journals.create') }}"><input type="submit" value="New Entry"></a>
                </div>
                <div class="journal-message">
                    <h2>Your Journal Entries</h2>
                </div>
            </section>
            <hr>
            <section class="filter">
                <form action="{{ route('journals.index') }}" method="get" id="filterForm">
                    <div class="search-filter">
                        <input type="search" placeholder="Search..." name="search" value="{{ request('search') }}">
                    </div>
                    <div class="date-filter">
                        <p>Filter by Date: </p>
                        <input type="date" name="date" value="{{ request('date') }}" class="date">
                        <input type="submit" name="filter" value="Filter" class="filter">
                        <input type="submit" name="clearBtn" value="Clear" class="clearBtn" id="clearBtn">
                    </div>
                </form>
            </section>

            <script>
                document.getElementById('clearBtn').addEventListener('click', function() {
                    const form = document.getElementById('filterForm');
                    form.querySelector('input[name="search"]').value = '';
                    form.querySelector('input[name="date"]').value = '';
                    window.location.href = "{{ route('journals.index') }}";
                });
            </script>

            <section class="cards">
                @foreach ($journals as $journal)
                    <div class="entry-date"
                        style="background-color: {{ moodColor($journal->mood) }}; color: white; padding: 10px; border-radius: 8px 8px 0 0;">
                        <p>{{ \Carbon\Carbon::parse($journal->date)->format('d M Y') }}</p>
                    </div>
                    <article>

                        <div class="entry-title">
                            <h3>{{ $journal->title }}</h3>
                        </div>
                        <div class="entry-mood"
                            style="background-color: {{ moodColor($journal->mood) }}; color: white;">
                            <p>Mood: {{ $journal->mood }}</p>
                        </div>
                        <div class="entry-description">
                            <p>{{ Str::limit($journal->description, 300) }}</p>
                        </div>
                        <div class="button">
                            <a href="{{ route('journals.edit', $journal->id) }}">
                                <input type="submit" value="Edit" style="background-color: {{ moodColor($journal->mood) }};">
                            </a>
                            <form action="{{ route('journals.destroy', $journal->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" style="background-color: {{ moodColor($journal->mood) }};">
                            </form>
                            <a href="{{ route('journals.show', $journal->id) }}">
                                <input type="submit" value="view" style="background-color: {{ moodColor($journal->mood) }};">
                            </a>
                        </div>
                    </article>
                @endforeach
            </section>
        </main>

    </div>
</body>

</html>
