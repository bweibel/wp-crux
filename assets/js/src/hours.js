if ( 'loading' === document.readyState ) {
	// The DOM has not yet been loaded.
	document.addEventListener( 'DOMContentLoaded', init );

} else {
	// The DOM has already been loaded.
	init( );
}

function init() {
	console.log("Hours Loaded");
	SundownerHour();
}

function SundownerHour( ) {
	const lat = '44.00524155783333';
	const lng = '-121.2931869154';

	const sundownerEl = document.getElementById( 'sundowner' );

	if ( sundownerEl ) {
		fetchSunset();
	}

	function fetchSunset() {
		const url = `https://api.sunrise-sunset.org/json?lat=${lat}&lng=${lng}&formatted=0`;
		console.log(url);

		fetch(url)
			//Success
			.then(response => response.json())
			.then(response => {
				const sunsetData = response.results;
				const sunset = new Date(sunsetData.sunset);
				const sundowner = calculateSundowner(sunset);
				const sunsetRounded = roundTime( sunset.getHours() % 12, sunset.getMinutes() );
				const sunsetStartRounded = roundTime( sundowner.start.getHours() % 12, sundowner.start.getMinutes() );
				const sunsetEndRounded = roundTime( sundowner.end.getHours() % 12, sundowner.end.getMinutes() );

				document.getElementById( 'sunset' ).innerHTML = sunsetRounded.hour + ':' + sunsetRounded.minutes;
				document.getElementById( 'sundowner-hour' ).innerHTML = sunsetStartRounded.hour + ':' + sunsetStartRounded.minutes + ' - ' + sunsetEndRounded.hour + ':' + sunsetEndRounded.minutes;
			})
			// Error
			.catch(error => console.log(error));
	}

	/**
	 *
	 * @param {Date} sunset
	 * @return {string} hours:minutes
	 */
	function calculateSundowner( sunset ) {
		const sundownerStart = new Date( sunset.getTime() - ( 30 * 60 * 1000 ) );
		const sundownerEnd = new Date( sundownerStart.getTime() + ( 60 * 60 * 1000 ) );
		return { start: sundownerStart, end: sundownerEnd };
	}

	function roundTime( hours, minutes ) {
		let hourRounded = ((((minutes/105) + .5) | 0) + hours) % 24;
		let minutesRounded = (((minutes + 7.5)/15 | 0) * 15) % 60;
		if ( minutesRounded == 0 ) {
			minutesRounded = '00';
		}

		return { hour: String( hourRounded ), minutes: String( minutesRounded ) }
	}
}
