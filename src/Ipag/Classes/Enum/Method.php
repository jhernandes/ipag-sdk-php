<?php

namespace Ipag\Classes\Enum;

abstract class Method
{
    const VISA = 'visa';
    const MASTERCARD = 'mastercard';
    const DINERS = 'diners';
    const AMEX = 'amex';
    const ELO = 'elo';
    const DISCOVER = 'discover';
    const HIPERCARD = 'hipercard';
    const JCB = 'jcb';
    const AURA = 'aura';
    const VISAELECTRON = 'visaelectron';
    const MAESTRO = 'maestro';

    const BANKSLIP_ITAU = 'boleto_itau';
    const BANKSLIP_BRADESCO = 'boleto_bradesco';
    const BANKSLIP_BB = 'boletobb';
    const BANKSLIP_SANTANDER = 'boleto_banespasantander';
    const BANKSLIP_ZOOP = 'boletozoop';
    const BANKSLIP_STONE = 'boletostone';
    const BANKSLIP_CIELO = 'boletocielo';
    const BANKSLIP_ITAUSHOPLINE = 'boletoitaushopline';
    const BANKSLIP_STELO = 'boletostelo';
    const BANKSLIP_UNIPRIME = 'boleto_uniprime';
    const BANKSLIP_BRADESCO_SHOP_FACIL = 'boletoshopfacil';
    const BANKSLIP_SICREDI = 'boletosicredi';
    const BANKSLIP_SICOOB = 'boletosicoob';

    const BANK_ITAUSHOPLINE = 'itaushopline';
    const BANK_BB = 'bancobrasil';
}
