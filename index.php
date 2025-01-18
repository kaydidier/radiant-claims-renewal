<? require "includes/header.view.php"; ?>

<main class="h-100 d-flex flex-column">

	<div id="" class="w-100">

		<section class="d-flex position-relative" id="hero">

			<div class="w-100 bg-opacity-50 md:bg-opacity-75">
				<img src="./images/radiant-hero.jpg" class="img-fluid opacity-75" alt=""
					style="height: 700px; width: 100%; object-fit: cover;" />
			</div>

			<div class="d-flex flex-column w-100 text-center text-white position-absolute bottom-0">
				<p class="fs-4">Get Radiant Insurance Company's services easily</p>

				<p class="fs-4">We help with insurance claims and renewals, making everything simple and stress-free</p>

				<div class="py-4">
					<a href="./login.view.php" class="text-decoration-none text-white">
						<button type="button" class="btn btn-primary">
							Get started
						</button>
					</a>
				</div>
			</div>
		</section>


		<section class="container py-4" id="about">
			<p class="text-center fw-bold fs-5">About Us</p>
			<p class="p-4">Radiant Insurance Company (Nyamirambo Branch) offers a wide range of services, including
				insurance claims, policy renewals, and new insurance coverage. Our goal is to provide our clients with
				high-quality, reliable services that make managing their insurance easy and stress-free. We put our
				clients at the forefront, ensuring that their needs are met with professionalism and care.

				Our experienced team is dedicated to guiding you through every step of the process, from filing claims
				to finding the right coverage for yourneeds. At Radiant Insurance Company, we are committed to
				delivering excellent customer service and building long-lasting relationships with ourclients. We strive
				to make your insurance experience smooth, transparent, and tailored to your individual needs.</p>
		</section>

		<section class="container d-flex flex-column justify-content-center py-4" id="services">
			<p class="text-center fw-bold fs-5">Services</p>
			<div class="d-flex">
				<div class="border p-4 rounded m-3 bg-light hover:bg-dark" style="cursor: pointer; ">
					<p class="fw-bold">Insurance Claims</p>
					<p>Trust our reliable insurance claims service to guide you through the process smoothly. We ensure
						fast, efficient support to help you get the compensation you deserve, with no stress or delays.
					</p>
				</div>
				<div class="border p-4 rounded m-3 bg-light hover:bg-dark" style="cursor: pointer; ">
					<p class="fw-bold">Insurance Renewal</p>
					<p>Stay covered with our easy insurance renewals service. We help you renew your policies on time,
						ensuring continued protection and saving you from unnecessary hassle or interruptions in your
						coverage.</p>
				</div>
				<div class="border p-4 rounded m-3 bg-light hover:bg-dark" style="cursor: pointer; ">
					<p class="fw-bold">New Insurance</p>
					<p>Easily request new insurance through our system. Whether it's for motor, medical, or agriculture,
						we help you find the right coverage quickly and efficiently, with a smooth and straightforward
						process.</p>
				</div>
			</div>
		</section>

		<section id="contact">
			<? require "includes/footer.view.php" ?>
		</section>
	</div>
</main>