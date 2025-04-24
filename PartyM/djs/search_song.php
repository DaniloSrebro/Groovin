<?php
session_start(); // Start the session to access the user ID

// Spotify API credentials
$client_id = "e577720420da45439e19c7462e45b7dd";
$client_secret = "aec3955a237648e2ab00d583871cb0e2";

// Get the song name and dj_id from the AJAX request
$search_query = isset($_GET['song']) ? $_GET['song'] : '';
$dj_id = isset($_GET['dj_id']) ? $_GET['dj_id'] : 0; // Retrieve dj_id from the AJAX request


// Check if the cacert.pem file exists in the current directory
$cacert_path = __DIR__ . '/cacert.pem';
if (!file_exists($cacert_path)) {
    die("<p>Error: The file 'cacert.pem' was not found in the directory: " . __DIR__ . "</p>");
}

// Only proceed if search_query is set and not empty
if (!empty($search_query)) {
    // Obtain the access token using Client Credentials Flow
    $credentials = base64_encode($client_id . ":" . $client_secret);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic $credentials",
        "Content-Type: application/x-www-form-urlencoded"
    ]);
    curl_setopt($ch, CURLOPT_CAINFO, $cacert_path); // Explicitly set the CA certificate path

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Log cURL-specific error
        $curl_error = curl_error($ch);
        echo "<p>cURL Error: $curl_error</p>";
        curl_close($ch);
        exit;
    }

    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP response code
    curl_close($ch);

    if ($status_code != 200) {
        echo "<p>Failed to fetch token. Status code: $status_code</p>";
        echo "<p>Response: $response</p>";
        exit;
    }

    $data = json_decode($response, true);
    $access_token = isset($data['access_token']) ? $data['access_token'] : null;

    if (!$access_token) {
        echo "<p>Error: No access token received.</p>";
        echo "<p>Raw Response: $response</p>";
        exit;
    }

    // Query Spotify API for search results
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=" . urlencode($search_query) . "&type=track&limit=10");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token"
    ]);
    curl_setopt($ch, CURLOPT_CAINFO, $cacert_path); // Explicitly set the CA certificate path

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $curl_error = curl_error($ch);
        echo "<p>cURL Error while searching: $curl_error</p>";
        curl_close($ch);
        exit;
    }

    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status_code != 200) {
        echo "<p>Failed to search Spotify. Status code: $status_code</p>";
        echo "<p>Response: $response</p>";
        exit;
    }

    $data = json_decode($response, true);

    // Check if 'tracks' and 'items' exist in the response
    if (isset($data['tracks']) && isset($data['tracks']['items']) && count($data['tracks']['items']) > 0) {
        echo '<ul>'; // Start an unordered list for results

        foreach ($data['tracks']['items'] as $track) {
            // Use default values if any data is missing
            $song_name = isset($track['name']) ? $track['name'] : 'Unknown song';
            $artist_name = isset($track['artists'][0]['name']) ? $track['artists'][0]['name'] : 'Unknown artist';
            $album_name = isset($track['album']['name']) ? $track['album']['name'] : 'Unknown album';
            $spotify_url = isset($track['external_urls']['spotify']) ? $track['external_urls']['spotify'] : '#';
            $cover_image = isset($track['album']['images'][0]['url']) ? $track['album']['images'][0]['url'] : '';
            
            // Wrap each song item in a form with hidden inputs for the song data
            echo "<li>
                    <strong>$song_name</strong><br> by $artist_name
                    <br>Album: $album_name
                    
                    <br><img src='$cover_image' alt='Album cover for $album_name' style='max-width: 100px; margin-top: 10px;'>

                    <!-- Form to submit the song data -->
                    <form action='save_song.php' method='POST'>
                        <input type='hidden' name='song_name' value='$song_name'>
                        <input type='hidden' name='artist_name' value='$artist_name'>
                        <input type='hidden' name='album_name' value='$album_name'>
                        <input type='hidden' name='spotify_url' value='$spotify_url'>
                        <input type='hidden' name='cover_image' value='$cover_image'>
                        <input type='hidden' name='dj_id' value='$dj_id'>
                      
                       
                        
                        <!-- Button to submit the form -->
                        <button class='button-8' type='submit' name='save_song' value='submit'>Send</button>
                    </form>
                  </li>";
        }

        echo '</ul>'; // End the unordered list
    } else {
        echo "<p>No results found or unexpected response structure.</p>";
        echo "<pre>" . print_r($data, true) . "</pre>"; // Print raw response for debugging
    }
} else {
    echo "<p>Please enter a search query to search for songs.</p>";
}
?>
