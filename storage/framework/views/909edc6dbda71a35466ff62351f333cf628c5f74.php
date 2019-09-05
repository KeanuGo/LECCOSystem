<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			<?php if(Auth::User()->access_rights()->users_view): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Users</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->users_view): ?>
							<a href="<?php echo e(route('users.index')); ?>" class="link-tag view-a"> View Users </a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->member_view or
				Auth::User()->access_rights()->member_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Members</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->member_view): ?>
							<a href="<?php echo e(route('members.index')); ?>" class="link-tag view-a"> View Members </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->member_create): ?>
							<a href="<?php echo e(route('members.create')); ?>" class="link-tag add-a"> Add Member </a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->loans_view or
				Auth::User()->access_rights()->loans_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Loans</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->loans_view): ?>
							<a href="<?php echo e(route('loans.index')); ?>" class="link-tag view-a"> View Loans </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->loans_create): ?>
							<a href="<?php echo e(route('loans.create')); ?>" class="link-tag add-a"> Add Loan </a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->loans_view or
				Auth::User()->access_rights()->loans_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Loan Types</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->loans_view): ?>
							<a href="<?php echo e(route('loan_types.index')); ?>" class="link-tag view-a"> View Loan Types </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->loans_create): ?>
							<a href="<?php echo e(route('loan_types.create')); ?>" class="link-tag add-a"> Add Loan Type </a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->shares_view or
				Auth::User()->access_rights()->shares_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Shares</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->shares_view): ?>
							<a href="<?php echo e(route('shares.index')); ?>" class="link-tag view-a"> View Shares </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->shares_create): ?>
							<a href="<?php echo e(route('shares.create')); ?>" class="link-tag add-a">Add Shares</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->coa_view or
				Auth::User()->access_rights()->coa_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Chart of Accounts</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->coa_view): ?>
							<a href="<?php echo e(route('coa.index')); ?>" class="link-tag view-a"> View Chart </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->coa_create): ?>
							<a href="<?php echo e(route('coa.create')); ?>" class="link-tag add-a">Add Item</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->signatories_view or
				Auth::User()->access_rights()->signatories_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Signatories</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->signatories_view): ?>
							<a href="<?php echo e(route('signatories.index')); ?>" class="link-tag view-a"> View Signatories </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->signatories_create): ?>
							<a href="<?php echo e(route('signatories.create')); ?>" class="link-tag add-a">Add Signatory</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(Auth::User()->access_rights()->check_voucher_view or
				Auth::User()->access_rights()->check_voucher_create ): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Check Voucher</div>
					<div class="panel-body">
						<?php if(Auth::User()->access_rights()->check_voucher_view): ?>
							<a href="<?php echo e(route('check_voucher.index')); ?>" class="link-tag view-a"> View Check Voucher </a>
						<?php endif; ?>
						<?php if(Auth::User()->access_rights()->check_voucher_create): ?>
							<a href="<?php echo e(route('check_voucher.create')); ?>" class="link-tag add-a">Add Check Voucher</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
        </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>