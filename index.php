<?php
/**
 * 一款Typecho文档类主题
 *
 * @package BearDocs
 * @author BearNotion
 * @version 1.0.0
 * @link https://www.bearnotion.ru/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
    $this->need('header.php');
?>


<div class="uk-section uk-section-muted">
	<div class="uk-container">
		<div class="uk-child-width-1-3@m uk-grid-match uk-grid-small" data-uk-grid>
		    <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
		    <?php while($categorys->next()): ?>
		    <?php if ($categorys->levels === 0): ?>
			<div>
				<div class="uk-card uk-card uk-card-default uk-card-hover uk-card-body uk-inline uk-border-rounded">
					<a class="uk-position-cover" href="<?php $categorys->permalink(); ?>"></a>
					<div class="uk-grid-medium" data-uk-grid>
						<div class="uk-width-auto uk-text-secondary uk-flex uk-flex-middle">
						    <span data-uk-icon="icon: <?php echo General::getCategoryDescriptionData($categorys->description)['icon']; ?>; ratio: 2.6"></span>
						</div>
						<div class="uk-width-expand">
							<h3 class="uk-card-title uk-margin-remove uk-text-secondary uk-category-name"><?php $categorys->name(); ?></h3>
							<p class="uk-text-muted uk-margin-remove uk-category-desc"><?php echo General::getCategoryDescriptionData($categorys->description)['desc']; ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endwhile; ?>
			</div>
	</div>
</div>

<?php if (General::Options('commonProblem_module') == true): ?>
<div class="uk-section uk-section-muted">
	<div class="uk-container uk-container-small">
		<h2 class="uk-text-center">常见问题解答</h2>
		<ul class="uk-margin-medium-top" data-uk-accordion="multiple: true">
		    <?php foreach(General::Options('commonProblem') as $commonProblem):?>
			<li>
				<a class="uk-accordion-title uk-box-shadow-hover-small"><?php echo $commonProblem['commonProblem_title']; ?></a>
				<div class="uk-article-content uk-accordion-content link-secondary">
					<p><?php echo $commonProblem['commonProblem_answer']; ?></p>
				</div>
			</li>
	<?php endforeach;?>
		</ul>
	</div>
</div>

<?php endif; ?>


<?php $this->need('footer.php'); ?>