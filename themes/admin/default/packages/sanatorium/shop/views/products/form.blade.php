@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ trans("action.{$mode}") }}} {{ trans('sanatorium/shop::products/common.title') }}
@stop

{{-- Queue assets --}}
{{ Asset::queue('validate', 'platform/js/validate.js', 'jquery') }}

{{ Asset::queue('selectize', 'selectize/css/selectize.bootstrap3.css', 'styles') }}
{{ Asset::queue('selectize', 'selectize/js/selectize.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
@stop

{{-- Inline styles --}}
@section('styles')
@parent
<style type="text/css">
	.attributes-inline hr, .attributes-inline .btn-primary,
	.attributes-inline legend {
		display: none;
	}
</style>
@stop

{{-- Page content --}}
@section('page')

<section class="panel panel-default panel-tabs">

	{{-- Form --}}
	<form id="shop-form" action="{{ request()->fullUrl() }}" role="form" method="post" data-parsley-validate>

		{{-- Form: CSRF Token --}}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<header class="panel-heading">

			<nav class="navbar navbar-default navbar-actions">

				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<a class="btn btn-navbar-cancel navbar-btn pull-left tip" href="{{ route('admin.sanatorium.shop.products.all') }}" data-toggle="tooltip" data-original-title="{{{ trans('action.cancel') }}}">
							<i class="fa fa-reply"></i> <span class="visible-xs-inline">{{{ trans('action.cancel') }}}</span>
						</a>

						<span class="navbar-brand">{{{ trans("action.{$mode}") }}} <small>{{{ $product->exists ? $product->id : null }}}</small></span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($product->exists)
							<li>
								<a href="{{ route('admin.sanatorium.shop.products.delete', $product->id) }}" class="tip" data-action-delete data-toggle="tooltip" data-original-title="{{{ trans('action.delete') }}}" type="delete">
									<i class="fa fa-trash-o"></i> <span class="visible-xs-inline">{{{ trans('action.delete') }}}</span>
								</a>
							</li>
							@endif

							<li>
								<button class="btn btn-primary navbar-btn" data-toggle="tooltip" data-original-title="{{{ trans('action.save') }}}">
									<i class="fa fa-save"></i> <span class="visible-xs-inline">{{{ trans('action.save') }}}</span>
								</button>
							</li>

						</ul>

					</div>

				</div>

			</nav>

		</header>

		<div class="panel-body">

			<div role="tabpanel">

				{{-- Form: Tabs --}}
				<ul class="nav nav-tabs" role="tablist">
					<li class="active" role="presentation"><a href="#general-tab" aria-controls="general-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.general') }}}</a></li>
					{{--
					<li role="presentation"><a href="#attributes-tab" aria-controls="attributes-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.attributes') }}}</a></li>--}}
					
					<li role="presentation"><a href="#pricing-tab" aria-controls="pricing-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.pricing') }}}</a></li>
					<li role="presentation"><a href="#tags-tab" aria-controls="tags-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.tags') }}}</a></li>
					<li role="presentation"><a href="#urls-tab" aria-controls="urls-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.urls') }}}</a></li>
					<li role="presentation"><a href="#attachments-tab" aria-controls="attachments-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.attachments') }}}</a></li>
					<li role="presentation"><a href="#categories-tab" aria-controls="categories-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.categories') }}}</a></li>
					<li role="presentation"><a href="#manufacturers-tab" aria-controls="manufacturers-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/shop::products/common.tabs.manufacturers') }}}</a></li>
					<li role="presentation"><a href="#before_after-tab" aria-controls="before_after-tab" role="tab" data-toggle="tab">Before / After</a></li>
				</ul>

				<div class="tab-content">

					{{-- Tab: General --}}
					<div role="tabpanel" class="tab-pane fade in active" id="general-tab">

						<fieldset>

							<div class="row">

								<div class="col-sm-6">

									<div class="attributes-inline">

										@attributes($product, ['product_cover'])

									</div>

									<div class="attributes-inline">

										@attributes($product, ['product_gallery'])

									</div>

								</div>

								<div class="col-sm-6">

									<div class="attributes-inline">

										@attributes($product, ['product_title'])

									</div>

									<div class="attributes-inline">

										@attributes($product, ['product_description'])

									</div>

									<div class="attributes-inline">

										@attributes($product, ['video'])

									</div>

									<div class="form-group{{ Alert::onForm('slug', ' has-error') }}">

										<label for="slug" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/shop::products/model.general.slug_help') }}}"></i>
											{{{ trans('sanatorium/shop::products/model.general.slug') }}}
										</label>

										<input type="text" class="form-control" name="slug" id="slug" placeholder="{{{ trans('sanatorium/shop::products/model.general.slug') }}}" value="{{{ input()->old('slug', $product->slug) }}}">

										<span class="help-block">{{{ Alert::onForm('slug') }}}</span>

									</div>

									<div class="form-group{{ Alert::onForm('code', ' has-error') }}">

										<label for="code" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/shop::products/model.general.code_help') }}}"></i>
											{{{ trans('sanatorium/shop::products/model.general.code') }}}
										</label>

										<input type="text" class="form-control" name="code" id="code" placeholder="{{{ trans('sanatorium/shop::products/model.general.code') }}}" value="{{{ input()->old('code', $product->code) }}}">

										<span class="help-block">{{{ Alert::onForm('code') }}}</span>

									</div>

									<div class="form-group{{ Alert::onForm('ean', ' has-error') }}">

										<label for="ean" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/shop::products/model.general.ean_help') }}}"></i>
											{{{ trans('sanatorium/shop::products/model.general.ean') }}}
										</label>

										<input type="text" class="form-control" name="ean" id="ean" placeholder="{{{ trans('sanatorium/shop::products/model.general.ean') }}}" value="{{{ input()->old('ean', $product->ean) }}}">

										<span class="help-block">{{{ Alert::onForm('ean') }}}</span>

									</div>

									<div class="form-group{{ Alert::onForm('weight', ' has-error') }}">

										<label for="weight" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/shop::products/model.general.weight_help') }}}"></i>
											{{{ trans('sanatorium/shop::products/model.general.weight') }}}
										</label>

										<input type="text" class="form-control" name="weight" id="weight" placeholder="{{{ trans('sanatorium/shop::products/model.general.weight') }}}" value="{{{ input()->old('weight', $product->weight) }}}">

										<span class="help-block">{{{ Alert::onForm('weight') }}}</span>

									</div>

									<div class="form-group{{ Alert::onForm('stock', ' has-error') }}">

										<label for="stock" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/shop::products/model.general.stock_help') }}}"></i>
											{{{ trans('sanatorium/shop::products/model.general.stock') }}}
										</label>

										<input type="text" class="form-control" name="stock" id="stock" placeholder="{{{ trans('sanatorium/shop::products/model.general.stock') }}}" value="{{{ input()->old('stock', $product->stock) }}}">

										<span class="help-block">{{{ Alert::onForm('stock') }}}</span>

									</div>

								</div>

							</div>

						</fieldset>

					</div>

					{{-- Tab: Attributes --}}
					{{-- 
					<div role="tabpanel" class="tab-pane fade" id="attributes-tab">
						@attributes($product)
					</div>
					--}}

					{{-- Tab: Pricing --}}
					<div role="tabpanel" class="tab-pane fade" id="pricing-tab">
						@pricing($product)
					</div>

					{{-- Tab: Tags --}}
					<div role="tabpanel" class="tab-pane fade" id="tags-tab">						

						<fieldset>

							<legend>{{{ trans('platform/tags::model.tag.legend') }}}</legend>

							@tags($product, 'tags')

						</fieldset>

					</div>
					
					<?php /*
					<div class="tab-pane fade" id="urls-tab">
						
						<div class="attributes-inline">

							@attributes($product, ['product_urls'])

						</div>

					</div>*/?>

					<div class="tab-pane fade" id="attachments-tab">
						
						<div class="attributes-inline">

							@attributes($product, ['attachments'])

						</div>

					</div>

					<div class="tab-pane fade" id="categories-tab">
						
						<div class="attributes-inline">

							@categories($product, 0, 'default-tree')

						</div>

					</div>

					<div class="tab-pane fade" id="manufacturers-tab">
						
						<div class="attributes-inline">

							@manufacturers($product)

						</div>

					</div>

					<div class="tab-pane fade" id="before_after-tab">
						
						<div class="attributes-inline">

							@attributes($product, ['before_image', 'after_image'])

						</div>

					</div>

				</div>

			</div>

		</div>

	</form>

</section>
@stop
