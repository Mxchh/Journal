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
        <div class="title-center">
            <div class="title">
                <h1>New Journal Entry</h1>
            </div>
        </div>

        <div class="entry-box">
            <form action="{{ route('journals.store') }}" method="post">
                @csrf
                <div class="date">
                    <p>Date</p>
                    <input type="date" name="date">
                </div>
                <div class="title">
                    <p>Title</p>
                    <input type="text" placeholder="Enter title for your journal entry..." name="title">
                </div>
                <div class="mood">
                    <p>Mood</p>
                    <select name="mood" id="mood" name="mood">
                        <option value="select">--Select Mood--</option>
                        <option value="Happy">Happy</option>
                        <option value="Sad">Sad</option>
                        <option value="Excited">Excited</option>
                        <option value="Disappointed">Disappointed</option>
                        <option value="Angry">Angry</option>
                        <option value="In Love">In Love</option>
                    </select>
                </div>
                <div class="description">
                    <p>Journal Entry</p>
                    <textarea name="description" id="description" rows="5" cols="50" placeholder="Write about your day..." name="decription"></textarea>
                </div>
                <div class="button">
                    <input type="submit" value="Save Entry">
                    <button type="button" onclick="window.location='{{ route('journals.index') }}'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
