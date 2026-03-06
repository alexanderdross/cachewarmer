/**
 * SearchForge Theme — FAQ accordion.
 */
( function() {
	'use strict';

	const buttons = document.querySelectorAll( '.sf-faq__question' );

	buttons.forEach( function( button ) {
		button.addEventListener( 'click', function() {
			const expanded = this.getAttribute( 'aria-expanded' ) === 'true';
			const answerId = this.getAttribute( 'aria-controls' );
			const answer   = document.getElementById( answerId );

			// Close all others.
			buttons.forEach( function( other ) {
				if ( other !== button ) {
					other.setAttribute( 'aria-expanded', 'false' );
					const otherId = other.getAttribute( 'aria-controls' );
					const otherAnswer = document.getElementById( otherId );
					if ( otherAnswer ) otherAnswer.hidden = true;
				}
			} );

			// Toggle current.
			this.setAttribute( 'aria-expanded', String( ! expanded ) );
			if ( answer ) answer.hidden = expanded;
		} );
	} );
} )();
