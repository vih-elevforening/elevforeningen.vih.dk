<?php
require 'include_elevforeningen_login.php';

$contact = $auth->getContact($_SESSION['contact_id']);
$client = new IntrafacePublic_Shop_XMLRPC_Client($credentials, false);

$basket = $client->getBasket();

$items = utf8_decoding($basket['items']);
$amount = $basket['price_total'];

$form = new HTML_QuickForm;
$form->addElement('submit', 'tilmeld', 'Bestil');

if (count($items) > 0) {
    $form_view = '
    <h2>Betaling</h2>
    <dl>
        <dt>Betal med Dankort</dt>
        <dd>Du betaler med <span class="dankort">Dankort</span>. Men først skal du have bestilt noget.</dd>
    </dl>
    ' . $form->toHTML();
} else {
    $form_view = '';
}

if ($form->validate()) {
    $order = array(
        'contact_id' => $contact['id'],
        'description' => 'Tilmelding ' . date('Y')
    );

    //$amount = $client->getBasketPrice();
    $order_id = $client->placeOrder($order);

    // $debtor_client = new DebtorClient(array('private_key' => $private_key), false);
    // $debtor_client->setSent($order_id);

    $_SESSION['order_id'] = $order_id;
    $_SESSION['amount'] = $amount;

    header('Location: betaling.php');
    exit;
}

$basket = new Template(PATH_TEMPLATE);
$basket->set('items', $items);
$basket->set('total_price', $amount);

$tpl = new Template(PATH_TEMPLATE_KUNDELOGIN);
$tpl->set('title', 'Indkøbskurv');
$tpl->set('description', '');
$tpl->set('keywords', '');
$tpl->set('content_main', $basket->fetch('elevforeningen/basket.tpl.php') . '
    ' . $form_view);

echo $tpl->fetch('main.tpl.php');