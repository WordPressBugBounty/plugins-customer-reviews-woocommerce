<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ($qna as $q) {
	?>
	<div class="cr-qna-list-q-cont">
		<div class="cr-qna-list-q-q">
			<div class="cr-qna-list-q-q-l">
				<svg class="cr-qna-list-q-icon" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="11" cy="11" r="10.25" stroke="#276A56" stroke-width="1.5"/>
				<path d="M11.7668 13.0628H10.1794V12.5437C10.1794 12.1066 10.2422 11.7468 10.3677 11.4645C10.4933 11.1821 10.7265 10.877 11.0673 10.5492L11.6726 9.96175C12.0852 9.57923 12.2915 9.17395 12.2915 8.7459C12.2915 8.3816 12.1749 8.08106 11.9417 7.84426C11.7175 7.60747 11.4126 7.48907 11.0269 7.48907C10.6233 7.48907 10.296 7.63024 10.0448 7.91257C9.80269 8.18579 9.67265 8.51821 9.65471 8.90984L8 8.75956C8.09865 7.90346 8.43498 7.22951 9.00897 6.7377C9.58296 6.2459 10.2915 6 11.1345 6C11.9507 6 12.6323 6.23224 13.1794 6.69672C13.7265 7.1612 14 7.80783 14 8.63661C14 9.16484 13.8969 9.5929 13.6906 9.92077C13.4843 10.2486 13.139 10.6266 12.6547 11.0546C12.287 11.3825 12.0448 11.6466 11.9283 11.847C11.8206 12.0383 11.7668 12.3251 11.7668 12.7076V13.0628ZM10.2332 15.6995C10.0179 15.4991 9.91031 15.2532 9.91031 14.9617C9.91031 14.6703 10.0135 14.4199 10.2197 14.2104C10.435 14.0009 10.6906 13.8962 10.9865 13.8962C11.2825 13.8962 11.5336 13.9964 11.7399 14.1967C11.9552 14.3971 12.0628 14.643 12.0628 14.9344C12.0628 15.2259 11.9552 15.4763 11.7399 15.6858C11.5336 15.8953 11.2825 16 10.9865 16C10.6996 16 10.4484 15.8998 10.2332 15.6995Z" fill="#31856C"/>
				</svg>
			</div>
			<div class="cr-qna-list-q-q-r">
				<span class="cr-qna-list-question"><?php echo $q['question']; ?></span>
				<span class="cr-qna-list-q-author"><?php echo sprintf( __( '%s asked on %s', 'customer-reviews-woocommerce' ), '<span class="cr-qna-list-q-author-b">' . esc_html( $q['author'] ) . '</span>', date_i18n( $date_format, strtotime( $q['date'] ) ) ); ?></span>
			</div>
		</div>
		<?php
		if( isset( $q['answers'] ) && is_array( $q['answers'] ) && 0 < count( $q['answers'] ) ) :
		?>
		<div class="cr-qna-list-q-a">
			<div class="cr-qna-list-q-a-l">
				<svg class="cr-qna-list-q-icon" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0)">
				<path d="M11.5386 1C11.533 1.00563 11.5217 1.00563 11.5049 1.00563C5.81081 1.00563 1.18018 5.63625 1.18018 11.3303C1.18018 13.654 1.97352 15.9103 3.42516 17.7276L1.92288 21.2161C1.79909 21.503 1.93413 21.835 2.21546 21.9532C2.31673 21.9982 2.42926 22.0094 2.53617 21.9925L8.04454 21.0248C9.14734 21.4243 10.3064 21.6268 11.4767 21.6212C17.1708 21.6212 21.8014 16.9906 21.8014 11.2965C21.8127 5.61937 17.2158 1.00563 11.5386 1ZM11.4823 20.5015C10.3964 20.5015 9.32176 20.3046 8.30336 19.922C8.20771 19.8826 8.10643 19.877 8.00515 19.8939L3.36889 20.7041L4.59548 17.8514C4.67988 17.6545 4.64612 17.4238 4.50545 17.2606C3.84152 16.4898 3.31263 15.6121 2.94128 14.6612C2.52492 13.5978 2.31111 12.4668 2.31111 11.3247C2.31111 6.24954 6.44098 2.1253 11.5105 2.1253C16.5687 2.11405 20.6761 6.20453 20.6817 11.2628C20.6817 11.274 20.6817 11.2853 20.6817 11.2965C20.6817 16.3773 16.5518 20.5015 11.4823 20.5015Z" fill="#31856C" stroke="#31856C" stroke-width="0.6"/>
				<rect x="7.29126" y="9.3999" width="8.4" height="1.575" fill="#31856C"/><rect x="7.29102" y="12.0244" width="6.3" height="1.575" fill="#31856C"/></g>
				<defs><clipPath id="clip0"><rect width="22" height="22" fill="white"/></clipPath></defs>
				</svg>
			</div>
			<div class="cr-qna-list-q-a-r">
				<?php
				$cr_i = 0;
				$cr_len = count( $q['answers'] );
				foreach ($q['answers'] as $a) {
					if( $cr_i === $cr_len-1 ) {
						$cr_class_qna_list_answer = 'cr-qna-list-answer cr-qna-list-last';
					} else {
						$cr_class_qna_list_answer = 'cr-qna-list-answer';
					}
					?>
					<div class="<?php echo $cr_class_qna_list_answer; ?>">
						<span class="cr-qna-list-answer-s"><?php echo $a['answer']; ?></span>
						<span class="cr-qna-list-q-author"><?php echo sprintf( __( '%s answered on %s', 'customer-reviews-woocommerce' ), '<span class="cr-qna-list-q-author-b">' . esc_html( $a['author'] ) . '</span>', date_i18n( $date_format, strtotime( $a['date'] ) ) ); ?></span>
						<?php
							if( 1 === $a['author_type'] ) {
								$store_manager = apply_filters( 'cr_qna_store_manager', __( 'store manager', 'customer-reviews-woocommerce' ) );
								$store_manager_svg = '<svg class="cr-qna-list-v-icon" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="cr-store-manager-svg" d="M14.26 2.7401C12.7215 1.20157 10.6758 0.354248 8.50002 0.354248C6.3241 0.354248 4.27857 1.20157 2.74004 2.7401C1.20151 4.27863 0.354187 6.32416 0.354187 8.50008C0.354187 10.6759 1.20151 12.7215 2.74004 14.2601C4.27857 15.7986 6.3241 16.6459 8.50002 16.6459C10.6758 16.6459 12.7215 15.7986 14.26 14.2601C15.7985 12.7215 16.6459 10.6759 16.6459 8.50008C16.6459 6.32416 15.7985 4.27863 14.26 2.7401ZM4.43792 14.4308C4.77861 12.4692 6.47848 11.0223 8.50002 11.0223C10.5217 11.0223 12.2214 12.4692 12.5621 14.4308C11.4056 15.2255 10.0062 15.6913 8.50002 15.6913C6.99381 15.6913 5.59449 15.2255 4.43792 14.4308ZM5.90995 7.47763C5.90995 6.04935 7.07187 4.88756 8.50002 4.88756C9.92818 4.88756 11.0901 6.04947 11.0901 7.47763C11.0901 8.90578 9.92818 10.0677 8.50002 10.0677C7.07187 10.0677 5.90995 8.90578 5.90995 7.47763ZM13.3889 13.7687C13.132 12.8555 12.6218 12.027 11.9066 11.3798C11.4678 10.9826 10.9684 10.6693 10.4314 10.4484C11.4019 9.81538 12.0448 8.72021 12.0448 7.47763C12.0448 5.52308 10.4546 3.93297 8.50002 3.93297C6.54547 3.93297 4.95536 5.52308 4.95536 7.47763C4.95536 8.72021 5.59822 9.81538 6.56859 10.4484C6.03176 10.6693 5.53222 10.9825 5.09345 11.3796C4.37838 12.0268 3.86802 12.8554 3.6111 13.7686C2.196 12.4544 1.30878 10.5791 1.30878 8.50008C1.30878 4.5348 4.53474 1.30884 8.50002 1.30884C12.4653 1.30884 15.6913 4.5348 15.6913 8.50008C15.6913 10.5792 14.804 12.4545 13.3889 13.7687Z" fill="#31856C" stroke="#31856C" stroke-width="0.5"/>
								</svg>';
								echo '<span class="cr-qna-list-q-author-verified">';
								echo $store_manager_svg;
								echo esc_html__( $store_manager, 'customer-reviews-woocommerce' ) . '</span>';
							} elseif( 2 === $a['author_type'] ) {
								$verified_svg = '<svg class="cr-qna-list-v-icon" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path class="cr-verified-circle-svg" fill-rule="evenodd" clip-rule="evenodd" d="M8.5 15.3C12.2555 15.3 15.3 12.2555 15.3 8.5C15.3 4.74446 12.2555 1.7 8.5 1.7C4.74446 1.7 1.7 4.74446 1.7 8.5C1.7 12.2555 4.74446 15.3 8.5 15.3ZM8.5 17C13.1944 17 17 13.1944 17 8.5C17 3.80558 13.1944 0 8.5 0C3.80558 0 0 3.80558 0 8.5C0 13.1944 3.80558 17 8.5 17Z" fill="#31856C"/>
								<path class="cr-verified-tick-svg" fill-rule="evenodd" clip-rule="evenodd" d="M4.42148 7.4927C4.75343 7.16076 5.29162 7.16076 5.62356 7.4927L7.6892 9.55835L11.3183 5.92926C11.6502 5.59731 12.1884 5.59731 12.5204 5.92926C12.8523 6.2612 12.8523 6.79939 12.5204 7.13134L7.6892 11.9625L4.42148 8.69479C4.08953 8.36284 4.08954 7.82465 4.42148 7.4927Z" fill="#31856C"/>
								</svg>';
								echo '<span class="cr-qna-list-q-author-verified">';
								echo $verified_svg;
								echo $cr_verified_label . '</span>';
							}
						?>
					</div>
					<?php
					$cr_i++;
				}
				?>
			</div>
		</div>
		<?php
		endif;
		?>
		<div class="cr-qna-list-q-b" data-question="<?php echo $q['id']; ?>" data-post="<?php echo $q['post']; ?>">
			<div class="cr-qna-list-q-b-l"></div>
			<?php
				$class_cr_qna_list_q_b_r = 'cr-qna-list-q-b-r';
				if ( ! in_array( $cr_qna_permissions, ['registered', 'anybody'] ) ) {
					$class_cr_qna_list_q_b_r .= ' cr-qna-list-q-b-r-no-ans';
				}
			?>
			<div class="<?php echo esc_attr( $class_cr_qna_list_q_b_r ); ?>">
				<button type="button" class="cr-qna-ans-button">
					<?php _e( 'Answer the question', 'customer-reviews-woocommerce' ); ?>
				</button>
				<div class="cr-qna-q-voting cr-voting-cont-uni cr-qna-q-voting-<?php echo $q['id']; ?>" data-vquestion="<?php echo $q['id']; ?>">
					<span class="cr-voting-upvote cr-voting-a<?php echo ( $q['votes']['current'] > 0 ? ' cr-voting-active' : '' ); ?>" data-vote="<?php echo $q['id']; ?>" data-upvote="1">
						<svg width="1000" height="1227" viewBox="0 0 1000 1227" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path class="cr-voting-svg-int" d="M644.626 317.445C649.154 317.445 652.363 317.445 655.572 317.445C723.597 317.449 791.624 317.158 859.648 317.572C898.609 317.808 933.112 330.638 960.638 358.82C995.241 394.246 1006.17 436.789 996.788 485.136C990.243 518.839 984.39 552.677 978.124 586.435C972.353 617.536 966.435 648.611 960.597 679.7C953.013 720.085 946.573 760.728 937.577 800.796C926.489 850.175 895.987 884.112 848.079 900.497C832.798 905.724 815.765 907.905 799.527 907.935C549.65 908.388 299.771 908.259 49.8947 908.247C25.2463 908.245 10.0803 898.71 2.61154 877.687C0.677947 872.241 0.300995 866.015 0.297088 860.148C0.175995 710.546 0.422088 560.945 0.000213738 411.345C-0.075958 384.09 20.215 362.994 48.6134 363.302C113.65 364.009 178.699 363.433 243.742 363.648C250.986 363.672 256.344 361.898 261.676 356.627C300.166 318.564 338.904 280.75 377.791 243.088C390.217 231.053 394.06 215.312 397.885 199.588C410.045 149.59 413.808 98.6035 414.676 47.3575C414.918 33.1016 417.97 19.961 429.484 11.1564C436.297 5.94738 445.088 0.58606 453.191 0.257936C503.865 -1.7948 551.841 8.18175 593.892 38.2071C628.316 62.7872 644.705 96.9199 644.634 139.162C644.541 194.99 644.621 250.818 644.625 306.646C644.626 309.849 644.626 313.051 644.626 317.445Z" fill="#00A382" fill-opacity="0.4"/>
							<path class="cr-voting-svg-ext" d="M644.626 317.445C649.154 317.445 652.363 317.445 655.572 317.445C723.597 317.449 791.624 317.158 859.648 317.572C898.609 317.808 933.112 330.638 960.638 358.82C995.241 394.246 1006.17 436.789 996.788 485.136C990.243 518.839 984.39 552.677 978.124 586.435C972.353 617.536 966.435 648.611 960.597 679.7C953.013 720.085 946.573 760.728 937.577 800.796C926.489 850.175 895.987 884.112 848.079 900.497C832.798 905.724 815.765 907.905 799.527 907.935C549.65 908.388 299.771 908.259 49.8947 908.247C25.2463 908.245 10.0803 898.71 2.61154 877.687C0.677947 872.241 0.300995 866.015 0.297088 860.147C0.175995 710.546 0.422088 560.945 0.000213738 411.345C-0.075958 384.09 20.215 362.994 48.6134 363.302C113.65 364.009 178.699 363.433 243.742 363.648C250.986 363.672 256.344 361.898 261.676 356.627C300.166 318.564 338.904 280.75 377.791 243.088C390.217 231.053 394.06 215.312 397.884 199.588C410.045 149.59 413.808 98.6035 414.675 47.3575C414.918 33.1016 417.97 19.961 429.484 11.1564C436.297 5.94738 445.088 0.58606 453.191 0.257936C503.865 -1.7948 551.841 8.18175 593.892 38.2071C628.316 62.7872 644.705 96.9199 644.634 139.162C644.54 194.99 644.621 250.818 644.624 306.646C644.626 309.849 644.626 313.051 644.626 317.445ZM565.625 819.015C565.625 819.036 565.625 819.058 565.625 819.081C643.392 819.081 721.159 819.091 798.925 819.075C828.847 819.069 847.042 803.902 852.509 774.366C861.169 727.589 869.743 680.798 878.411 634.023C888.853 577.675 899.495 521.365 909.747 464.984C913.148 446.285 908.323 430.019 892.739 417.99C882.896 410.392 871.601 407.894 859.249 407.918C774.708 408.082 690.167 407.929 605.626 408.064C588.71 408.091 574.158 403.558 563.621 389.513C556.435 379.935 554.595 368.881 554.597 357.283C554.609 285.207 554.316 213.127 554.812 141.055C554.927 124.215 547.863 113.125 533.511 106.08C526.277 102.527 518.486 100.119 511.005 97.0488C504.636 94.4355 502.461 96.4629 502.093 103.281C499.685 147.967 493.855 192.172 480.816 235.115C473.15 260.361 463.355 284.873 444.131 303.847C404.035 343.418 363.549 382.591 323.033 421.73C318.933 425.691 317.385 429.689 317.389 435.23C317.48 559.603 317.431 683.976 317.433 808.349C317.433 818.991 317.513 819.013 328.258 819.013C407.381 819.017 486.502 819.015 565.625 819.015ZM226.81 818.503C226.81 696.718 226.81 575.511 226.81 454.082C181.205 454.082 136.127 454.082 90.797 454.082C90.797 575.755 90.797 696.941 90.797 818.503C136.418 818.503 181.504 818.503 226.81 818.503Z" fill="#00A382"/>
						</svg>
					</span>
					<span class="cr-qna-q-voting-upvote cr-voting-upvote-count">(<?php
						if( isset( $q['votes'] ) && isset( $q['votes']['upvotes'] ) ) {
							echo intval( $q['votes']['upvotes'] );
						} else {
							echo '0';
						} ?>)</span>
					<span class="cr-voting-downvote cr-voting-a<?php echo ( $q['votes']['current'] < 0 ? ' cr-voting-active' : '' ); ?>" data-vote="<?php echo $q['id']; ?>" data-upvote="0">
						<svg width="1000" height="1227" viewBox="0 0 1000 1227" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path class="cr-voting-svg-int" d="M355.375 909.828C350.847 909.828 347.638 909.828 344.429 909.828C276.404 909.824 208.377 910.115 140.353 909.701C101.392 909.465 66.8886 896.635 39.3632 868.453C4.75973 833.028 -6.17383 790.485 3.21288 742.137C9.7578 708.434 15.6113 674.596 21.8769 640.838C27.6484 609.737 33.5664 578.663 39.4042 547.573C46.9882 507.188 53.4277 466.546 62.4238 426.477C73.5117 377.099 104.014 343.161 151.922 326.776C167.203 321.55 184.236 319.368 200.474 319.339C450.351 318.886 700.23 319.015 950.106 319.026C974.755 319.028 989.921 328.564 997.39 349.587C999.323 355.032 999.7 361.259 999.704 367.126C999.825 516.727 999.579 666.329 1000 815.928C1000.08 843.184 979.786 864.28 951.388 863.971C886.351 863.264 821.302 863.84 756.259 863.625C749.015 863.602 743.657 865.375 738.325 870.647C699.835 908.709 661.097 946.524 622.21 984.186C609.784 996.221 605.941 1011.96 602.116 1027.69C589.956 1077.68 586.193 1128.67 585.325 1179.92C585.083 1194.17 582.031 1207.31 570.517 1216.12C563.704 1221.33 554.913 1226.69 546.81 1227.02C496.136 1229.07 448.16 1219.09 406.109 1189.07C371.685 1164.49 355.296 1130.35 355.367 1088.11C355.46 1032.28 355.38 976.455 355.376 920.627C355.375 917.424 355.375 914.223 355.375 909.828Z" fill="#CA2430" fill-opacity="0.4"/>
							<path class="cr-voting-svg-ext" d="M355.374 909.828C350.847 909.828 347.638 909.828 344.429 909.828C276.403 909.824 208.376 910.115 140.353 909.701C101.392 909.464 66.8882 896.634 39.3628 868.453C4.75934 833.027 -6.17424 790.484 3.21247 742.137C9.75739 708.433 15.6109 674.596 21.8765 640.838C27.648 609.736 33.566 578.662 39.4038 547.572C46.9878 507.188 53.4272 466.545 62.4233 426.477C73.5112 377.098 104.013 343.161 151.921 326.776C167.202 321.549 184.236 319.368 200.474 319.338C450.351 318.885 700.229 319.014 950.106 319.026C974.754 319.028 989.92 328.563 997.389 349.586C999.323 355.032 999.7 361.258 999.703 367.125C999.825 516.727 999.578 666.328 1000 815.928C1000.08 843.183 979.785 864.279 951.387 863.97C886.35 863.263 821.301 863.84 756.258 863.625C749.014 863.601 743.657 865.375 738.325 870.646C699.835 908.709 661.096 946.523 622.21 984.185C609.784 996.22 605.94 1011.96 602.116 1027.69C589.956 1077.68 586.192 1128.67 585.325 1179.92C585.083 1194.17 582.03 1207.31 570.516 1216.12C563.704 1221.33 554.913 1226.69 546.809 1227.01C496.136 1229.07 448.159 1219.09 406.108 1189.07C371.685 1164.49 355.296 1130.35 355.366 1088.11C355.46 1032.28 355.38 976.455 355.376 920.627C355.374 917.423 355.374 914.222 355.374 909.828ZM434.376 408.258C434.376 408.237 434.376 408.215 434.376 408.192C356.609 408.192 278.841 408.182 201.076 408.198C171.154 408.203 152.958 423.371 147.492 452.906C138.831 499.684 130.257 546.475 121.589 593.25C111.148 649.598 100.505 705.908 90.2534 762.289C86.853 780.988 91.6772 797.254 107.261 809.283C117.105 816.881 128.4 819.379 140.751 819.355C225.292 819.191 309.833 819.344 394.374 819.209C411.29 819.181 425.843 823.715 436.38 837.76C443.565 847.338 445.405 858.392 445.403 869.99C445.392 942.066 445.685 1014.15 445.188 1086.22C445.073 1103.06 452.138 1114.15 466.489 1121.19C473.724 1124.75 481.515 1127.15 488.995 1130.22C495.364 1132.84 497.54 1130.81 497.907 1123.99C500.315 1079.31 506.145 1035.1 519.184 992.158C526.851 966.912 536.645 942.4 555.87 923.425C595.966 883.855 636.452 844.681 676.967 805.543C681.067 801.582 682.616 797.584 682.612 792.043C682.52 667.67 682.569 543.297 682.567 418.924C682.567 408.282 682.487 408.26 671.743 408.26C592.62 408.256 513.499 408.258 434.376 408.258ZM773.19 408.77C773.19 530.555 773.19 651.762 773.19 773.191C818.795 773.191 863.874 773.191 909.204 773.191C909.204 651.518 909.204 530.332 909.204 408.77C863.583 408.77 818.497 408.77 773.19 408.77Z" fill="#CA2430"/>
						</svg>
					</span>
					<span class="cr-qna-q-voting-downvote cr-voting-downvote-count">(<?php
						if( isset( $q['votes'] ) && isset( $q['votes']['downvotes'] ) ) {
							echo intval( $q['votes']['downvotes'] );
						} else {
							echo '0';
						} ?>)</span>
				</div>
			</div>
			<div class="cr-qna-list-inl-answ">
				<div class="cr-review-form-nav">
					<div class="cr-nav-left">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M16.9607 19.2506L11.0396 13.3295L16.9607 7.40833" stroke="#0E252C" stroke-miterlimit="10"/>
						</svg>
						<span>
							<?php _e( 'Add an answer', 'customer-reviews-woocommerce' ); ?>
						</span>
					</div>
					<div class="cr-nav-right">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8.61914 8.62009L19.381 19.3799M8.61914 19.3799L19.381 8.62009" stroke="#0E252C" stroke-miterlimit="10" stroke-linejoin="round"/>
						</svg>
					</div>
				</div>
				<?php if ( 'registered' === $cr_qna_permissions && ! is_user_logged_in() ) : ?>
					<div class="cr-review-form-not-logged-in">
						<span>
							<?php _e( 'You must be logged in to answer a question', 'customer-reviews-woocommerce' ); ?>
						</span>
						<?php
							if ( $cr_qna_login ) {
								$cr_qna_login = add_query_arg( 'redirect_to', urlencode( $cr_permalink ), $cr_qna_login );
							} else {
								$cr_qna_login = wp_login_url( $cr_permalink );
							}
						?>
						<a class="cr-review-form-continue" href="<?php echo esc_url( $cr_qna_login ); ?>" rel="nofollow"><?php _e( 'Log In', 'customer-reviews-woocommerce' ); ?></a>
					</div>
				<?php elseif ( 'anybody' === $cr_qna_permissions || ( 'registered' === $cr_qna_permissions && is_user_logged_in() ) ) : ?>
					<div class="cr-review-form-comment">
						<div class="cr-review-form-lbl">
							<?php _e( 'Your answer', 'customer-reviews-woocommerce' ); ?>
						</div>
						<textarea rows="4" name="cr_review_form_comment_txt" class="cr-review-form-comment-txt" placeholder="<?php _e( 'Write your answer here', 'customer-reviews-woocommerce' ); ?>"></textarea>
						<div class="cr-review-form-field-error">
							<?php _e( '* Answer is required', 'customer-reviews-woocommerce' ); ?>
						</div>
					</div>
					<div class="cr-review-form-ne">
						<div class="cr-review-form-name">
							<div class="cr-review-form-lbl">
								<?php _e( 'Name', 'customer-reviews-woocommerce' ); ?>
							</div>
							<input type="text" name="cr_review_form_name" class="cr-review-form-txt" autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'customer-reviews-woocommerce' ); ?>"></input>
							<div class="cr-review-form-field-error">
								<?php _e( '* Name is required', 'customer-reviews-woocommerce' ); ?>
							</div>
						</div>
						<div class="cr-review-form-email">
							<div class="cr-review-form-lbl">
								<?php _e( 'Email', 'customer-reviews-woocommerce' ); ?>
							</div>
							<input type="email" name="cr_review_form_email" class="cr-review-form-txt" autocomplete="email" placeholder="<?php esc_attr_e( 'Your email', 'customer-reviews-woocommerce' ); ?>"></input>
							<div class="cr-review-form-field-error">
								<?php _e( '* Email is required', 'customer-reviews-woocommerce' ); ?>
							</div>
						</div>
					</div>
					<?php if ( $cr_qna_checkbox ) : ?>
						<div class="cr-review-form-terms">
							<label>
								<input type="checkbox" class="cr-review-form-checkbox" name="cr_review_form_checkbox" />
								<span><?php echo $cr_qna_checkbox_text; ?></span>
							</label>
							<div class="cr-review-form-field-error">
								<?php _e( '* Please tick the checkbox to proceed', 'customer-reviews-woocommerce' ); ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( 0 < strlen( $cr_recaptcha ) ) : ?>
						<div class="cr-captcha-terms">
							<?php echo sprintf( esc_html( __( 'This site is protected by reCAPTCHA and the Google %1$sPrivacy Policy%2$s and %3$sTerms of Service%4$s apply.', 'customer-reviews-woocommerce' ) ), '<a href="https://policies.google.com/privacy" rel="noopener noreferrer nofollow" target="_blank">', '</a>', '<a href="https://policies.google.com/terms" rel="noopener noreferrer nofollow" target="_blank">', '</a>' ); ?>
						</div>
					<?php endif; ?>
					<div class="cr-review-form-buttons">
						<button type="button" class="cr-review-form-submit" data-crcptcha="<?php echo $cr_recaptcha; ?>">
							<span><?php _e( 'Submit', 'customer-reviews-woocommerce' ); ?></span>
							<img src="<?php echo CR_Utils::cr_get_plugin_dir_url() . 'img/spinner-dots.svg'; ?>" alt="Loading" />
						</button>
						<button type="button" class="cr-review-form-cancel">
							<?php _e( 'Cancel', 'customer-reviews-woocommerce' ); ?>
						</button>
					</div>
					<div class="cr-review-form-result">
						<span></span>
						<button type="button" class="cr-review-form-continue" aria-label="<?php echo esc_attr__( 'Continue', 'customer-reviews-woocommerce' ); ?>"></button>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}
