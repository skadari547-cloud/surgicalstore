<?php
require_once __DIR__ . '/../includes/db.php';
require 'layout.php';
userStart('Offers', 'offers');
$coupons = db_all("
SELECT *
FROM coupons
WHERE status = 'active'
AND (start_date IS NULL OR start_date <= NOW())
AND (expiry_date IS NULL OR expiry_date >= NOW())
ORDER BY coupon_id DESC
");
?>
<div class="container">
<div class="page-head">
<span class="eyebrow">SPECIAL OFFERS</span>
<h1>Available Coupons</h1>
<p>Discover discounts and save on your surgical store purchases.</p>
</div>
<div class="offers-grid">

        
<?php
if (!empty($coupons)):
?>
            
<?php
foreach ($coupons as $c):
?>
                <div class="offer-coupon-card">
<div class="offer-coupon-info">
<h3>
<?=
h($c['coupon_code'])
?>
</h3>
<p>
                            
<?php
if ($c['discount_type'] === 'percentage')  {
echo h($c['discount_value']) . '% OFF';
}
else  {
echo '₹' . number_format(
(float)$c['discount_value'],
2
) . ' OFF';
}
?>
                        </p>
<p>
                            Minimum order:
                            ₹
<?=
number_format(
(float)$c['min_order_amount'],
2
)
?>
                        </p>

                        
<?php
if (!empty($c['expiry_date'])):
?>
                            <small>
                                Valid until:
                                
<?=
h(date(
'd M Y',
strtotime($c['expiry_date'])
))
?>
                            </small>
                        
<?php
endif;
?>
                    </div>
</div>

            
<?php
endforeach;
?>
        
<?php
else:
?>
            <p>No active coupons available right now.</p>

        
<?php
endif;
?>
    </div>
</div>
<?php
userEnd();
?>
