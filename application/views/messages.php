<?php if($this->session->flashdata('success')) : ?>
    <script>
        toastr.success('<?= trim($this->session->flashdata('success')); ?>');
    </script>
<?php endif ; ?>

<?php if($this->session->flashdata('danger')) : ?>
    <script>
        toastr.error('<?= trim($this->session->flashdata('danger')); ?>');
    </script>
<?php endif ; ?>

<?php if($this->session->flashdata('info')) : ?>
    <script>
        toastr.info('<?= trim($this->session->flashdata('info')); ?>');
    </script>
<?php endif ; ?>

<?php if($this->session->flashdata('warning')) : ?>
    <script>
        toastr.warning('<?= trim($this->session->flashdata('warning')); ?>');
    </script>
<?php endif ; ?>

