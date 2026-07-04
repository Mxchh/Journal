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
                <div class="search-filter">
                    <input type="search" placeholder="Search...">
                </div>
                <div class="date-filter">
                    <p>Filter by Date: </p>
                    <input type="date">
                </div>
            </section>
            <section class="cards">
                @foreach ($journals as $journal)
                    <article>
                        <div class="entry-date">
                            <p>{{ $journal->date }}</p>
                        </div>
                        <div class="entry-title">
                            <h3>{{ $journal->title }}</h3>
                        </div>
                        <div class="entry-mood">
                            <p>Mood: {{ $journal->mood }}</p>
                        </div>
                        <div class="entry-description">
                            <p>{{ $journal->description }}</p>
                        </div>
                        <div class="button">
                            <a href="{{ route('journals.edit', $journal->id) }}">
                                <input type="submit" value="Edit">
                            </a>
                            <form action="{{ route('journals.destroy', $journal->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete">
                            </form>
                            <input type="submit" value="view">
                        </div>
                    </article>
                @endforeach
            </section>
        </main>

    </div>
</body>

</html>