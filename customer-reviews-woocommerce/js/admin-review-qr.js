/* global CrReviewQRStrings, qrcode, ajaxurl, jQuery */
jQuery(function ($) {
	// Build a scalable QR code; the PNG copy is rasterized from its 24px-per-module size.
	const buildSvg = function (qr) {
		const margin = 4;
		const count = qr.getModuleCount();
		const total = count + margin * 2;
		let modules = '';
		for (let row = 0; row < count; row++) {
			for (let column = 0; column < count; column++) {
				if (qr.isDark(row, column)) {
					modules += `M${column + margin} ${row + margin}h1v1h-1z`;
				}
			}
		}
		const attribution = CrReviewQRStrings.attribution;
		// Place the attribution in the lower quiet zone, keeping at least one module clear next to the code.
		// Text and star proportions follow the "Powered by" credits on review widgets.
		const fontSize = total * 0.032;
		const starHeight = fontSize * 1.6;
		const starWidth = (starHeight * 84) / 79;
		const gap = fontSize * 0.4;
		const center = count + margin + 1 + starHeight / 2;
		const height = attribution
			? Math.max(total, center + starHeight / 2 + 1.5)
			: total;
		let credits = '';
		if (attribution) {
			const fontFamily = 'Helvetica, Arial, sans-serif';
			const measure = document.createElement('canvas').getContext('2d');
			measure.font = `${fontSize * 100}px ${fontFamily}`;
			const textWidth = measure.measureText(attribution).width / 100;
			const left = (total - textWidth - gap - starWidth) / 2;
			const escaped = attribution.replace(
				/[&<>"]/g,
				(char) =>
					({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' })[
						char
					]
			);
			credits =
				`<text x="${left + textWidth}" y="${center}" font-family="${fontFamily}" font-size="${fontSize}" fill="#50575e" text-anchor="end" dominant-baseline="central">${escaped}</text>` +
				`<g transform="translate(${left + textWidth + gap} ${center - starHeight / 2}) scale(${starHeight / 79})">` +
				'<path d="M41.97 65.51 16.07 79l4.94-28.57L0 30.16l29.05-4.18L41.97 0l12.98 25.98L84 30.16 62.99 50.43 67.93 79Z" fill="#F4DB6B"/>' +
				'<path d="M31.08 46.48c0 5.95 4.88 10.78 10.89 10.78s10.9-4.83 10.9-10.78Z" fill="#E98B3E"/>' +
				'<circle cx="32.45" cy="37.41" r="3.21" fill="#E98B3E"/>' +
				'<circle cx="51.56" cy="37.41" r="3.21" fill="#E98B3E"/>' +
				'<path d="M41.97 0 29.05 25.98 0 30.16l33.52.89ZM16.07 79l25.9-13.49L67.93 79 41.97 58.62Z" fill="#F6D15A"/>' +
				'</g>';
		}
		return (
			`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${total} ${height}" width="${total * 24}" height="${height * 24}">` +
			`<rect width="${total}" height="${height}" fill="#fff"/>` +
			`<path d="${modules}" fill="#000" shape-rendering="crispEdges"/>` +
			credits +
			'</svg>'
		);
	};

	$('.wp-list-table').on('click', '.cr-send-qr-button', function (event) {
		event.preventDefault();
		const menu = $(this).closest('.cr-send-menu');
		const trigger = menu.parent().find('.ivole-order').get(0);
		const dialog = $(
			'<dialog class="cr-review-qr-dialog" aria-labelledby="cr-review-qr-title"></dialog>'
		);
		const title = $('<h2 id="cr-review-qr-title"></h2>').text(
			CrReviewQRStrings.title
		);
		const status = $('<p role="status" aria-live="polite"></p>').text(
			CrReviewQRStrings.loading
		);
		const image = $('<img class="cr-review-qr-image" hidden>').attr(
			'alt',
			CrReviewQRStrings.image_alt
		);
		const notice = $('<p hidden></p>').text(
			CrReviewQRStrings.private_notice
		);
		const actions = $('<div class="cr-review-qr-actions"></div>');
		const feedback = $(
			'<p class="cr-review-qr-feedback" role="status" aria-live="polite"></p>'
		);
		const copy = $(
			'<button type="button" class="button" disabled></button>'
		).text(CrReviewQRStrings.copy);
		const print = $(
			'<button type="button" class="button" disabled></button>'
		).text(CrReviewQRStrings.print);
		const close = $(
			'<button type="button" class="cr-review-qr-close"><span class="dashicons dashicons-no-alt" aria-hidden="true"></span></button>'
		).attr('aria-label', CrReviewQRStrings.close);
		let imageBlob;

		$('.cr-review-qr-dialog').each(function () {
			this.close();
		});
		actions.append(copy, print);
		dialog
			.append(close, title, status, image, notice, actions, feedback)
			.appendTo('body');
		dialog.on('close', function () {
			$('#tiptip_holder').trigger('mouseleave').stop(true, true).hide();
			dialog.remove();
			if (trigger) {
				trigger.focus();
			}
		});
		close.on('click', function () {
			dialog.get(0).close();
		});
		// Backdrop clicks target the dialog itself, outside its bounding box.
		dialog.on('click', function (e) {
			if (e.target !== this) {
				return;
			}
			const rect = this.getBoundingClientRect();
			if (
				e.clientX < rect.left ||
				e.clientX > rect.right ||
				e.clientY < rect.top ||
				e.clientY > rect.bottom
			) {
				this.close();
			}
		});
		dialog.get(0).showModal();

		$.ajax({
			url: ajaxurl,
			method: 'POST',
			dataType: 'json',
			data: {
				action: 'cr_manual_review_reminder_qr',
				order_id: menu.data('orderid'),
				nonce: menu.data('nonce'),
			},
		})
			.done(function (response) {
				if (!dialog.get(0).open) {
					return;
				}
				if (
					!response ||
					0 !== response.code ||
					typeof response.message !== 'string'
				) {
					status.text(
						response && response.message
							? response.message
							: CrReviewQRStrings.error
					);
					return;
				}
				try {
					const url = new URL(response.message);
					if (!['http:', 'https:'].includes(url.protocol)) {
						throw new Error(CrReviewQRStrings.error);
					}
					const qr = qrcode(0, 'M');
					// Encode Unicode URLs as UTF-8 instead of the library's default single-byte encoding.
					const bytes = new TextEncoder().encode(response.message);
					qr.addData(String.fromCharCode(...bytes), 'Byte');
					qr.make();
					const svgUrl =
						'data:image/svg+xml;charset=utf-8,' +
						encodeURIComponent(buildSvg(qr));
					const svgImage = new window.Image();
					svgImage.onload = function () {
						if (!dialog.get(0).open) {
							return;
						}
						// Clipboard targets widely accept PNG, not SVG.
						const canvas = document.createElement('canvas');
						canvas.width = svgImage.naturalWidth;
						canvas.height = svgImage.naturalHeight;
						canvas.getContext('2d').drawImage(svgImage, 0, 0);
						canvas.toBlob(function (blob) {
							if (!dialog.get(0).open) {
								return;
							}
							if (!blob) {
								status.text(CrReviewQRStrings.error);
								return;
							}
							imageBlob = blob;
							image.attr('src', svgUrl).prop('hidden', false);
							print.prop('disabled', false);
							if (
								window.isSecureContext &&
								navigator.clipboard &&
								navigator.clipboard.write &&
								window.ClipboardItem
							) {
								copy.prop('disabled', false);
							} else {
								feedback.text(
									CrReviewQRStrings.copy_unavailable
								);
							}
							status.remove();
							notice.prop('hidden', false);
						}, 'image/png');
					};
					svgImage.onerror = function () {
						status.text(CrReviewQRStrings.error);
					};
					svgImage.src = svgUrl;
				} catch {
					status.text(CrReviewQRStrings.error);
				}
			})
			.fail(function () {
				status.text(CrReviewQRStrings.error);
			});

		copy.on('click', async function () {
			copy.prop('disabled', true);
			feedback.text('');
			try {
				await navigator.clipboard.write([
					new window.ClipboardItem({ 'image/png': imageBlob }),
				]);
				feedback.text(CrReviewQRStrings.copied);
			} catch {
				feedback.text(CrReviewQRStrings.copy_error);
			} finally {
				copy.prop('disabled', false);
			}
		});
		print.on('click', function () {
			$('.cr-review-qr-print-frame').remove();
			const frame = $(
				'<iframe class="cr-review-qr-print-frame" title=""></iframe>'
			)
				.attr('title', CrReviewQRStrings.title)
				.appendTo('body');
			try {
				const printWindow = frame.get(0).contentWindow;
				const printDocument = printWindow.document;
				printDocument.title = CrReviewQRStrings.title;
				const style = printDocument.createElement('style');
				style.textContent =
					'body { margin: 20mm; text-align: center; } img { width: 80mm; height: auto; max-width: 100%; }';
				printDocument.head.appendChild(style);
				const printImage = printDocument.createElement('img');
				printImage.alt = CrReviewQRStrings.image_alt;
				printImage.onload = function () {
					try {
						printWindow.addEventListener(
							'afterprint',
							function () {
								frame.remove();
							},
							{ once: true }
						);
						printWindow.focus();
						printWindow.print();
					} catch {
						frame.remove();
						feedback.text(CrReviewQRStrings.print_error);
					}
				};
				printImage.onerror = function () {
					frame.remove();
					feedback.text(CrReviewQRStrings.print_error);
				};
				printDocument.body.appendChild(printImage);
				printImage.src = image.attr('src');
			} catch {
				frame.remove();
				feedback.text(CrReviewQRStrings.print_error);
			}
		});
		menu.remove();
		// The menu is removed before tipTip sees mouseleave, so hide its tooltip explicitly.
		$('#tiptip_holder').trigger('mouseleave').stop(true, true).hide();
	});
});
