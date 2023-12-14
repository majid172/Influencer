@extends($theme.'layouts.app')
@section('title', trans('Testimonial Accept	'))
@section('content')
	<section class="job-section">
		<div class="container">

				<div class="row g-lg-8">

					<div class="col-lg-12">
						<div class="d-md-flex justify-content-center align-items-center top-filter mb-4">
							<form action="{{route('testimonial.rating',$id)}}" method="post">
								@csrf
							<div class="card-box">
								<div class="form-group">
									<label for="note">@lang('Note')</label>
									<input type="text" class="form-control" name="note">
								</div>

								<div class="form-group add-review">
									<label for="ratings">@lang('Ratings')</label>
									<div class="rating">
										<input type="radio" id="star1" name="rating" value="5" />
										<label for="star1" title="text"></label>
										<input type="radio" id="star2" name="rating" value="4" />
										<label for="star2" title="text"></label>
										<input checked="" type="radio" id="star3" name="rating" value="3" />
										<label for="star3" title="text"></label>
										<input type="radio" id="star4" name="rating" value="2" />
										<label for="star4" title="text"></label>
										<input type="radio" id="star5" name="rating" value="1" />
										<label for="star5" title="text"></label>
									</div>
									<button type="submit" class="btn-custom w-100">@lang('Submit')</button>

								</div>
							</div>
							</form>
						</div>

					</div>
				</div>
		</div>


	</section>

@endsection

@push('style')
	<style>
		.add-review {
			margin-bottom: 50px;
		}
		.add-review .rating {
			display: flex;
			flex-direction: row-reverse;
			justify-content: start;
		}
		.add-review .rating:not(:checked) > input {
			position: absolute;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
		}
		.add-review .rating:not(:checked) > label {
			cursor: pointer;
			font-size: 36px;
			color: var(--borderColor);
		}
		.add-review .rating:not(:checked) > label:before {
			content: "★";
		}
		.add-review .rating > input:checked + label:hover,
		.add-review .rating > input:checked + label:hover ~ label,
		.add-review .rating > input:checked ~ label:hover,
		.add-review .rating > input:checked ~ label:hover ~ label,
		.add-review .rating > label:hover ~ input:checked ~ label {
			color: var(--gold);
		}
		.add-review .rating:not(:checked) > label:hover,
		.add-review .rating:not(:checked) > label:hover ~ label {
			color: var(--gold);
		}
		.add-review .rating > input:checked ~ label {
			color: var(--gold);
		}
		.add-review form .input-box label {
			font-weight: 500;
			margin-bottom: 10px;
			text-transform: capitalize;
		}
		.add-review form .input-box .form-select,
		.add-review form .input-box .form-control {
			height: 50px;
			border-radius: 5px;
			background-color: var(--bgLight);
			border: 1px solid var(--bgLight);
			padding: 8px;
			padding-left: 15px;
			font-weight: normal;
			caret-color: var(--primary);
			color: var(--fontColor);
		}
		.add-review form .input-box .form-select:focus,
		.add-review form .input-box .form-control:focus {
			color: var(--fontColor);
			box-shadow: 0 0 0 0rem var(--white);
			border: 1px solid var(--primary);
		}
		.add-review form .input-box .form-select::-moz-placeholder, .listing-details .add-review form .input-box .form-control::-moz-placeholder {
			color: var(--fontColor);
		}
		.add-review form .input-box .form-select::placeholder,
		.add-review form .input-box .form-control::placeholder {
			color: var(--fontColor);
		}
		.add-review form .input-box .form-select {
			background-image: url(../img/icon/downward-arrow.png);
		}
		.add-review form .input-box .form-select option {
			background: var(--white);
			color: var(--fontColor);
		}
		.add-review form .input-box textarea.form-control {
			height: 120px;
			border-radius: 5px;
		}
	</style>
@endpush
