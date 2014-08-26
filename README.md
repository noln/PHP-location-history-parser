Location History Parser
==============

Version 1.0

Intro.
--------------
This project parses a properly-formatted '.kml' file in PHP. By properly formatted, I mean that as of the day of publishing it works with a straight-exported KML file downloaded from the *Location History* tool.


Background
--------------
On a multi-month trip abroad, I wanted to keep a visual log of where I was going during my trip. Rather than use some purpose-built battery hogging app, I decided to make use of Google's less publicised but ever-present *Orwellian Asset Tracker*, **Location History** or rather of its export capability.

This project maps the data points in a single KML file, onto a Google Map. It also outputs the total distance.


Usage
--------------
- **Step 1** - Unzip to a web server directory; I can confirm that *XAMPP* works fine (as that is what I used when I was hacking this together in a coffee shop in *Montreal*. Ohh! Placename drop! :-P).

*Apache* or anything else that serves up PHP pages will work fine - it's vanilla, frameworkless PHP. Designed to be easy to understand, even for novices.

You'll notice that it doesn't work yet. There is no same location data provided in this project so you will need to download a copy of your own location data. To do that:

- **Step 2** - Decide your time period and get the start and end times in *Epoch time*. If you don't know how to do that, this site (http://www.epochconverter.com/) does the hard work for you.

Note: I'm not affiliated with *EpochConverter.com* in any way, but it came up in Google when I looked for it. I've saved you valuable Googling seconds. You're welcome.

- **Step 3** - Substitute your start and end times into this URL where it says *[start]* and *[end]*, ensuring that you have a 13-character long value for each - if it's not long enough, add some 0's to the end until it is.

```
https://maps.google.com/locationhistory/b/0/kml?startTime=[start]&endTime=[end]
```

**Note: You need to be logged in as the user that you want the location history of before you open the URL.** You also need to have Location History *enabled* on one or more of your devices for any data to appear. If you get nothing, turn it on and walk around for a day or so then try again.

- **Step 4** - Download the file by copy-pasting the URL into a browser and hitting enter, you should get a file named something like this:

```
history-08-25-2014.kml
```
   
- **Step 5** - Rename it to this:
	
```
location-history.kml
```
    
- **Step 6** - Copy it into the same folder that you extracted the project to before, and open the folder.

If your browser has default configuration, it should load up the main page listing the scripts out.