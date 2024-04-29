<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>

<main class="main-content">
	<section class="contact">
		<?php if ( have_posts() ): ?>
			<?php while ( have_posts() ): the_post(); ?>
				<article id="<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="grid-container">
						<div class="grid-x grid-margin-x">
							<div class="cell medium-6">
								<h1 class="page-title"><?php the_title(); ?></h1>

                                <!-- Form Task -->
                                <form action="" method="post">
                                    <input type="text" name="first_name" placeholder="First Name" required>
                                    <input type="text" name="last_name" placeholder="Last Name" Name>
                                    <input type="email" name="email" placeholder="Email" required>
                                    <input type="hidden" name="post_id"
                                           value="<?php echo isset($_GET['post_id']) ? $_GET['post_id'] : ''; ?>">
                                    <select id="subject" name="subject" required>
                                        <option value="Send only for me">Send only for me</option>
                                        <option value="Send to admin">Send to admin</option>
                                     </select><br>
                                    <textarea name="Message" placeholder="Your message" required cols="50" rows="10"
                                              style="resize: none;"></textarea>
                                    <br>
                                    <button type="submit">Submit</button>
                                </form>

                                <div id="message-container">
                                    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                                        <?php if (isset($_POST['first_name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['Message'])): ?>
                                            <?php

                                            $first_name = $_POST['first_name'];
                                            $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
                                            $email = $_POST['email'];
                                            $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
                                            $subject = $_POST['subject'];
                                            $message = $_POST['Message'];

                                            $full_name = $first_name . ' ' . $last_name;
                                            $full_message = "From: $full_name\nEmail: $email\nMessage: $message";
                                            ?>
                                            <?php
                                            $recipient_email = '';
                                            if ($subject === 'Send only for me'):
                                                $recipient_email = 'igor.m@thewhitelabelagency.com';
                                            elseif ($subject === 'Send to admin'):
                                                $recipient_email = 'maindeveloperwp@gmail.com';
                                            endif;
                                            ?>

                                            <?php if (!empty($recipient_email)): ?>
                                                <?php
                                                $subject_line = "Contact Form Submission - $subject";
                                                $headers = "From: $email";
                                                if (mail($recipient_email, $subject_line, $full_message, $headers)):
                                                    echo "The letter was sent successfully.";

                                                    $args = array(
                                                        'post_title' => $subject_line,
                                                        'post_content' => $full_message,
                                                        'post_status' => 'publish',
                                                        'post_type' => 'form_submissions'
                                                    );
                                                    $submission_id = wp_insert_post($args);
                                                else:
                                                    echo "Error sending email.";
                                                endif;
                                                ?>
                                            <?php else: ?>
                                                The recipient's address is incorrect.
                                            <?php endif; ?>

                                        <?php else: ?>
                                            Please fill in all the fields.
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <!-- END Form Task-->

								<div class="contact__content">
									<?php the_content(); ?>
								</div>
								<div class="contact__links">
									<?php if ( $address = get_field( 'address', 'option' ) ): ?>
										<address class="contact-link contact-link--address">
											<?php echo $address; ?>
										</address>
									<?php endif; ?>
									<?php if ( $email = get_field( 'email', 'options' ) ): ?>
										<p class="contact-link contact-link--email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
									<?php endif; ?>
									<?php if ( $phone = get_field( 'phone', 'options' ) ): ?>
										<p class="contact-link contact-link--phone"><a href="tel:<?php echo sanitize_number( $phone ); ?>"><?php echo $phone; ?></a></p>
									<?php endif; ?>
								</div>
							</div>
								<div class="cell medium-6">
								<?php if ( class_exists('GFAPI') && ( $contact_form = get_field( 'contact_form' ) ) && is_array( $contact_form ) ): ?>
									<div class="contact__form">
										<?php echo do_shortcode( "[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']" ); ?>
									</div>
							<?php endif; ?>
							</div>
							<?php if ( $location = get_field( 'location', 'options' ) ): ?>
								<div class="cell contact__map-wrap">
									<div class="acf-map contact__map">
										<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"
										     data-marker-icon="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/map-marker.png"><?php echo '<p>' . $location['address'] . '</p>'; ?></div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</section>
</main>

<?php get_footer(); ?>
