var area_icons = ["grndfloor", "firstfloor", "basement"];
var room_icons = ["kitchen", "bedroom", "tvlounge", "bathroom", "office", 'kidsroom', 'garage'];

/* Define range how many icon in various ranges */
var range = [];
range[1] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[2] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[3] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[4] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[5] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[6] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[7] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[8] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[9] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[10] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[11] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[12] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
range[13] = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

function findRangeIcon(usage, percent) {
	var nearest, last_d_memorized = 101;
	var set = range[usage];
	// We iterate on the array...
	for (var i = 0; i < set.length ;i++) {
		// if we found the desired number, we return it.
		var value = set[i];
		if (value == percent) {
			return value;
		} else {
			// else, we consider the difference between the desired number and the current number in the array.
			var d = Math.abs(percent - value);
			if (d < last_d_memorized) {
				// For the moment, this value is the nearest to the desired number...
				nearest = value;
				last_d_memorized = d; //is the actual shortest found delta 
			}
		}
	}
	return nearest;
}