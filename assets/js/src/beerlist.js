if ( 'loading' === document.readyState ) {
	// The DOM has not yet been loaded.
	document.addEventListener( 'DOMContentLoaded', init );

} else {
	// The DOM has already been loaded.
	init( );
}

window.addEventListener( 'load', function() {
	setTimeout(checkURL, 1200);
}
);


function init() {
	BeerList( 'list-container', 'filter-controls' );
	BeerList( 'archive-container' );
	const archiveListEl = document.getElementById( 'archive-list' );
	const archiveButton = document.getElementById( 'archive-button' );
	const featuredEl = document.getElementById( 'featured-beers' );
	const featuredBeers = [ ...featuredEl.getElementsByClassName( 'featured-beer') ];

	if ( featuredBeers ) {
		featuredBeers.forEach( ( beer ) => {
			beer.addEventListener( 'click', ( ) => {
				openBeerById( beer.dataset.id );
			} );
		} );
	}

	addClickToggle(archiveButton, archiveListEl );

}

function BeerList(listId, filterId = '') {
	const listEl = document.getElementById(listId );
	const beerEls = [ ...listEl.querySelectorAll( '.beer') ];
	const filterEl = document.getElementById(filterId );
	const filterNameEl = document.getElementById( 'filter-name' );

	if ( filterEl ) {
		initFilters( );
	}

	if ( beerEls ) {
		initBeers( );
	}

	function initBeers() {
		beerEls.forEach((beer) => {
			addClickToggle(beer.getElementsByClassName( 'beer-header' )[ 0 ], beer );
		} );
	}

	function initFilters() {
		addClickToggle(
			filterEl.getElementsByClassName( 'filter-header')[ 0 ],
			filterEl
		);
		const filterEls = [...document.getElementsByClassName( 'filter-button')];
		filterEls.forEach((button) => {
			button.addEventListener( 'click', () => {
				filterEls.forEach((button) => {
					button.classList.remove( 'active' );
				} );
				button.classList.add( 'active' );
				updateFilter(
					button.dataset.filterslug,
					button.dataset.filtername
				);
			} );
		} );
	}

	function updateFilter(newFilter, newFilterName) {
		// Update filter name
		if (newFilter) {
			filterNameEl.innerHTML = newFilterName;
		} else {
			filterNameEl.innerHTML = '';
		}

		beerEls.forEach((beer) => {
			if (! newFilter) {
				beer.classList.remove( 'hidden' );
			} else if (! beer.classList.contains( 'beer_series-' + newFilter)) {
				beer.classList.add( 'hidden' );
			} else {
				beer.classList.remove( 'hidden' );
			}

		} );
		//Close the filter menu after switching
		filterEl.classList.remove( 'open' );
	}
}

function addClickToggle(el, target ) {
	el.addEventListener( 'click', () => {
		beerClickHandler( target );
	} );
}

function beerClickHandler( target ) {
	if (! target.classList.contains( 'open' ) ) {
		target.classList.add( 'open' );
	} else {
		target.classList.remove( 'open' );
	}
}

function openBeerById( beerId ) {
	const target = document.getElementById( beerId );
	if ( target ) {
		if ( ! target.classList.contains( 'open' ) ) {
			target.classList.add( 'open' );
		}
		target.scrollIntoView( { behavior: 'smooth' } );
	}
}

function checkURL() {
	console.log("check");
	const queryString = window.location.search;
	if ( queryString ) {
		const urlParams = new URLSearchParams( queryString );
		const beer = urlParams.get( 'beer' );
		if ( beer ) {
			openBeerById( beer );
		}
	}
}
