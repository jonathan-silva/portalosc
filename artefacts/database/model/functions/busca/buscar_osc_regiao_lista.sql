DROP FUNCTION IF EXISTS portal.buscar_osc_regiao_lista(param NUMERIC);

CREATE OR REPLACE FUNCTION portal.buscar_osc_regiao_lista(param NUMERIC) RETURNS TABLE(
	id_osc INTEGER, 
	tx_nome_osc TEXT, 
	cd_identificador_osc NUMERIC(14, 0), 
	tx_natureza_juridica_osc TEXT, 
	tx_endereco_osc TEXT, 
	geo_lat DOUBLE PRECISION, 
	geo_lng DOUBLE PRECISION
) AS $$ 

DECLARE 
	id_osc_search INTEGER; 

BEGIN 
	RETURN QUERY 
		SELECT 
			vw_busca_resultado.id_osc, 
			vw_busca_resultado.tx_nome_osc, 
			vw_busca_resultado.cd_identificador_osc, 
			vw_busca_resultado.tx_natureza_juridica_osc, 
			vw_busca_resultado.tx_endereco_osc, 
			vw_busca_resultado.geo_lat, 
			vw_busca_resultado.geo_lng 
		FROM portal.vw_busca_resultado 
		WHERE vw_busca_resultado.id_osc IN (
			SELECT * FROM portal.buscar_osc_regiao(param)
		); 
END; 
$$ LANGUAGE 'plpgsql';
