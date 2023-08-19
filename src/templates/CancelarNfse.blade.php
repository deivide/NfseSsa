<CancelarNfseEnvio xmlns="http://www.abrasf.org.br/ABRASF/arquivos/nfse.xsd">
    <Pedido>
        <InfPedidoCancelamento id="{{ array_get($dados, 'id') }}">
            <IdentificacaoNfse>
                {!! array_xml_get($dados['identificacao_nfse'], 'numero') !!}
                {!! array_xml_get($dados['identificacao_nfse'], 'cnpj') !!}
                {!! array_xml_get($dados['identificacao_nfse'], 'inscricao_municipal') !!}
                {!! array_xml_get($dados['identificacao_nfse'], 'codigo_municipio') !!}
            </IdentificacaoNfse>
            {!! array_xml_get($dados, 'codigo_cancelamento') !!}
        </InfPedidoCancelamento>
    </Pedido>
</CancelarNfseEnvio>
