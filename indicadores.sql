PGDMP     5                	    r            indicadores    9.2.4    9.2.4 �   �
           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �
           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �
           1262    57401    indicadores    DATABASE     i   CREATE DATABASE indicadores WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'C' LC_CTYPE = 'C';
    DROP DATABASE indicadores;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �
           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    6            �
           0    0    public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    6            �            3079    11995    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �
           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    250            �            1259    57402    acao    TABLE       CREATE TABLE acao (
    id integer NOT NULL,
    titulo character varying(255),
    data_inicio_previsto date,
    data_fim_previsto date,
    concluido integer DEFAULT 0,
    data_conclusao date,
    status integer DEFAULT 1,
    observacao text,
    lembrete date,
    andamento character varying(255),
    responsavel_id integer,
    acao_id integer,
    supervisor_id integer,
    prioridade character varying(10),
    anomalia_id integer,
    objetivo_id integer,
    projeto_id integer,
    marco integer,
    ordem integer
);
    DROP TABLE public.acao;
       public         postgres    false    6            �            1259    57410    acao_id_seq    SEQUENCE     m   CREATE SEQUENCE acao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.acao_id_seq;
       public       postgres    false    168    6            �
           0    0    acao_id_seq    SEQUENCE OWNED BY     -   ALTER SEQUENCE acao_id_seq OWNED BY acao.id;
            public       postgres    false    169            �            1259    57412    acao_plano_acao    TABLE     j   CREATE TABLE acao_plano_acao (
    id integer NOT NULL,
    plano_acao_id integer,
    acao_id integer
);
 #   DROP TABLE public.acao_plano_acao;
       public         postgres    false    6            �            1259    57415    acao_plano_acao_id_seq    SEQUENCE     x   CREATE SEQUENCE acao_plano_acao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.acao_plano_acao_id_seq;
       public       postgres    false    170    6            �
           0    0    acao_plano_acao_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE acao_plano_acao_id_seq OWNED BY acao_plano_acao.id;
            public       postgres    false    171            �            1259    57417    acos    TABLE       CREATE TABLE acos (
    id integer NOT NULL,
    parent_id integer,
    model character varying(255) DEFAULT NULL::character varying,
    foreign_key integer,
    alias character varying(255) DEFAULT NULL::character varying,
    lft integer,
    rght integer
);
    DROP TABLE public.acos;
       public         postgres    false    6            �            1259    57425    acos_id_seq    SEQUENCE     m   CREATE SEQUENCE acos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.acos_id_seq;
       public       postgres    false    6    172            �
           0    0    acos_id_seq    SEQUENCE OWNED BY     -   ALTER SEQUENCE acos_id_seq OWNED BY acos.id;
            public       postgres    false    173            �            1259    57427    anomalia    TABLE     !  CREATE TABLE anomalia (
    id integer NOT NULL,
    causas_internas text,
    causas_externas text,
    data date,
    indicador_id integer,
    status integer DEFAULT 1,
    data_conclusao date,
    identificacao_problema text,
    estratificacao_problema text,
    concluido integer
);
    DROP TABLE public.anomalia;
       public         postgres    false    6            �
           0    0    anomalia    ACL     �   REVOKE ALL ON TABLE anomalia FROM PUBLIC;
REVOKE ALL ON TABLE anomalia FROM postgres;
GRANT ALL ON TABLE anomalia TO postgres;
GRANT ALL ON TABLE anomalia TO PUBLIC;
            public       postgres    false    174            �            1259    57434    anomalia_id_seq    SEQUENCE     q   CREATE SEQUENCE anomalia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.anomalia_id_seq;
       public       postgres    false    174    6            �
           0    0    anomalia_id_seq    SEQUENCE OWNED BY     5   ALTER SEQUENCE anomalia_id_seq OWNED BY anomalia.id;
            public       postgres    false    175            �
           0    0    anomalia_id_seq    ACL     �   REVOKE ALL ON SEQUENCE anomalia_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE anomalia_id_seq FROM postgres;
GRANT ALL ON SEQUENCE anomalia_id_seq TO postgres;
GRANT ALL ON SEQUENCE anomalia_id_seq TO PUBLIC;
            public       postgres    false    175            �            1259    57436    aros    TABLE       CREATE TABLE aros (
    id integer NOT NULL,
    parent_id integer,
    model character varying(255) DEFAULT NULL::character varying,
    foreign_key integer,
    alias character varying(255) DEFAULT NULL::character varying,
    lft integer,
    rght integer
);
    DROP TABLE public.aros;
       public         postgres    false    6            �            1259    57444 	   aros_acos    TABLE     �  CREATE TABLE aros_acos (
    id integer NOT NULL,
    aro_id integer NOT NULL,
    aco_id integer NOT NULL,
    _create character varying(2) DEFAULT '0'::character varying NOT NULL,
    _read character varying(2) DEFAULT '0'::character varying NOT NULL,
    _update character varying(2) DEFAULT '0'::character varying NOT NULL,
    _delete character varying(2) DEFAULT '0'::character varying NOT NULL
);
    DROP TABLE public.aros_acos;
       public         postgres    false    6            �            1259    57451    aros_acos_id_seq    SEQUENCE     r   CREATE SEQUENCE aros_acos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.aros_acos_id_seq;
       public       postgres    false    6    177            �
           0    0    aros_acos_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE aros_acos_id_seq OWNED BY aros_acos.id;
            public       postgres    false    178            �            1259    57453    aros_id_seq    SEQUENCE     m   CREATE SEQUENCE aros_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.aros_id_seq;
       public       postgres    false    6    176            �
           0    0    aros_id_seq    SEQUENCE OWNED BY     -   ALTER SEQUENCE aros_id_seq OWNED BY aros.id;
            public       postgres    false    179            �            1259    57455 	   auditoria    TABLE     �   CREATE TABLE auditoria (
    id integer NOT NULL,
    alias_controller character varying(255),
    alias_acao character varying(255),
    usuario_id integer,
    created timestamp without time zone,
    elemento_id character varying
);
    DROP TABLE public.auditoria;
       public         postgres    false    6            �
           0    0 	   auditoria    ACL     �   REVOKE ALL ON TABLE auditoria FROM PUBLIC;
REVOKE ALL ON TABLE auditoria FROM postgres;
GRANT ALL ON TABLE auditoria TO postgres;
GRANT ALL ON TABLE auditoria TO PUBLIC;
            public       postgres    false    180            �            1259    57461    auditoria_campos    TABLE     �   CREATE TABLE auditoria_campos (
    id integer NOT NULL,
    alias_model character varying(255),
    valor_antigo text,
    valor_novo text,
    auditoria_id integer,
    tipo_campo integer
);
 $   DROP TABLE public.auditoria_campos;
       public         postgres    false    6            �
           0    0    auditoria_campos    ACL     �   REVOKE ALL ON TABLE auditoria_campos FROM PUBLIC;
REVOKE ALL ON TABLE auditoria_campos FROM postgres;
GRANT ALL ON TABLE auditoria_campos TO postgres;
GRANT ALL ON TABLE auditoria_campos TO PUBLIC;
            public       postgres    false    181            �            1259    57467    auditoria_campos_id_seq    SEQUENCE     y   CREATE SEQUENCE auditoria_campos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.auditoria_campos_id_seq;
       public       postgres    false    181    6            �
           0    0    auditoria_campos_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE auditoria_campos_id_seq OWNED BY auditoria_campos.id;
            public       postgres    false    182            �
           0    0    auditoria_campos_id_seq    ACL     �   REVOKE ALL ON SEQUENCE auditoria_campos_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE auditoria_campos_id_seq FROM postgres;
GRANT ALL ON SEQUENCE auditoria_campos_id_seq TO postgres;
GRANT ALL ON SEQUENCE auditoria_campos_id_seq TO PUBLIC;
            public       postgres    false    182            �            1259    57469    auditoria_id_seq    SEQUENCE     r   CREATE SEQUENCE auditoria_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.auditoria_id_seq;
       public       postgres    false    180    6            �
           0    0    auditoria_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE auditoria_id_seq OWNED BY auditoria.id;
            public       postgres    false    183            �
           0    0    auditoria_id_seq    ACL     �   REVOKE ALL ON SEQUENCE auditoria_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE auditoria_id_seq FROM postgres;
GRANT ALL ON SEQUENCE auditoria_id_seq TO postgres;
GRANT ALL ON SEQUENCE auditoria_id_seq TO PUBLIC;
            public       postgres    false    183            �            1259    57471    cargo    TABLE     �   CREATE TABLE cargo (
    id integer NOT NULL,
    titulo character varying(255),
    descricao text,
    status integer DEFAULT 1
);
    DROP TABLE public.cargo;
       public         postgres    false    6            �            1259    57478    cargo_id_seq    SEQUENCE     n   CREATE SEQUENCE cargo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.cargo_id_seq;
       public       postgres    false    184    6            �
           0    0    cargo_id_seq    SEQUENCE OWNED BY     /   ALTER SEQUENCE cargo_id_seq OWNED BY cargo.id;
            public       postgres    false    185            �            1259    57480 	   categoria    TABLE     R   CREATE TABLE categoria (
    id integer NOT NULL,
    titulo character varying
);
    DROP TABLE public.categoria;
       public         postgres    false    6            �
           0    0 	   categoria    ACL     �   REVOKE ALL ON TABLE categoria FROM PUBLIC;
REVOKE ALL ON TABLE categoria FROM postgres;
GRANT ALL ON TABLE categoria TO postgres;
GRANT ALL ON TABLE categoria TO PUBLIC;
            public       postgres    false    186            �            1259    57486    categoria_id_seq    SEQUENCE     r   CREATE SEQUENCE categoria_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.categoria_id_seq;
       public       postgres    false    186    6            �
           0    0    categoria_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE categoria_id_seq OWNED BY categoria.id;
            public       postgres    false    187            �
           0    0    categoria_id_seq    ACL     �   REVOKE ALL ON SEQUENCE categoria_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE categoria_id_seq FROM postgres;
GRANT ALL ON SEQUENCE categoria_id_seq TO postgres;
GRANT ALL ON SEQUENCE categoria_id_seq TO PUBLIC;
            public       postgres    false    187            �            1259    57488 
   comentario    TABLE     �   CREATE TABLE comentario (
    id integer NOT NULL,
    mensagem text,
    arquivo character varying(255),
    usuario_id integer,
    acao_id integer
);
    DROP TABLE public.comentario;
       public         postgres    false    6            �            1259    57494    comentario_id_seq    SEQUENCE     s   CREATE SEQUENCE comentario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.comentario_id_seq;
       public       postgres    false    6    188            �
           0    0    comentario_id_seq    SEQUENCE OWNED BY     9   ALTER SEQUENCE comentario_id_seq OWNED BY comentario.id;
            public       postgres    false    189            �            1259    57496    comunicacao    TABLE     �   CREATE TABLE comunicacao (
    id integer NOT NULL,
    titulo character varying(255),
    status integer DEFAULT 1,
    tipo character varying(45)
);
    DROP TABLE public.comunicacao;
       public         postgres    false    6            �            1259    57500    comunicacao_id_seq    SEQUENCE     t   CREATE SEQUENCE comunicacao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.comunicacao_id_seq;
       public       postgres    false    190    6            �
           0    0    comunicacao_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE comunicacao_id_seq OWNED BY comunicacao.id;
            public       postgres    false    191            �            1259    57502    departamento    TABLE     x   CREATE TABLE departamento (
    id integer NOT NULL,
    titulo character varying(255),
    status integer DEFAULT 1
);
     DROP TABLE public.departamento;
       public         postgres    false    6            �            1259    57506    departamento_id_seq    SEQUENCE     u   CREATE SEQUENCE departamento_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.departamento_id_seq;
       public       postgres    false    192    6            �
           0    0    departamento_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE departamento_id_seq OWNED BY departamento.id;
            public       postgres    false    193            �            1259    57508    dimensao    TABLE     �   CREATE TABLE dimensao (
    id integer NOT NULL,
    titulo character varying(255),
    observacao text,
    ordem integer,
    status integer DEFAULT 1,
    empresa_id integer
);
    DROP TABLE public.dimensao;
       public         postgres    false    6            �            1259    57515    dimensao_id_seq    SEQUENCE     q   CREATE SEQUENCE dimensao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.dimensao_id_seq;
       public       postgres    false    194    6            �
           0    0    dimensao_id_seq    SEQUENCE OWNED BY     5   ALTER SEQUENCE dimensao_id_seq OWNED BY dimensao.id;
            public       postgres    false    195            �            1259    57517    empresa    TABLE       CREATE TABLE empresa (
    id integer NOT NULL,
    matriz integer,
    cnpj character varying(45),
    inscricao_estadual character varying(255),
    inscricao_municipal character varying(255),
    pessoa_id integer,
    empresa_id integer,
    status integer DEFAULT 1
);
    DROP TABLE public.empresa;
       public         postgres    false    6            �            1259    57524    empresa_id_seq    SEQUENCE     p   CREATE SEQUENCE empresa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.empresa_id_seq;
       public       postgres    false    196    6            �
           0    0    empresa_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE empresa_id_seq OWNED BY empresa.id;
            public       postgres    false    197            �            1259    57526    endereco    TABLE       CREATE TABLE endereco (
    id integer NOT NULL,
    logradouro character varying(255),
    cep character varying(45),
    bairro character varying(255),
    cidade character varying(255),
    numero character varying(45),
    uf character(2),
    status integer DEFAULT 1
);
    DROP TABLE public.endereco;
       public         postgres    false    6            �            1259    57533    endereco_id_seq    SEQUENCE     q   CREATE SEQUENCE endereco_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.endereco_id_seq;
       public       postgres    false    6    198            �
           0    0    endereco_id_seq    SEQUENCE OWNED BY     5   ALTER SEQUENCE endereco_id_seq OWNED BY endereco.id;
            public       postgres    false    199            �            1259    57535    faixa    TABLE     �   CREATE TABLE faixa (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    limite_vermelho double precision,
    limite_amarelo double precision,
    status integer DEFAULT 1 NOT NULL
);
    DROP TABLE public.faixa;
       public         postgres    false    6            �
           0    0    faixa    ACL     �   REVOKE ALL ON TABLE faixa FROM PUBLIC;
REVOKE ALL ON TABLE faixa FROM postgres;
GRANT ALL ON TABLE faixa TO postgres;
GRANT ALL ON TABLE faixa TO PUBLIC;
            public       postgres    false    200            �            1259    57539    faixa_id_seq    SEQUENCE     n   CREATE SEQUENCE faixa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.faixa_id_seq;
       public       postgres    false    6    200            �
           0    0    faixa_id_seq    SEQUENCE OWNED BY     /   ALTER SEQUENCE faixa_id_seq OWNED BY faixa.id;
            public       postgres    false    201            �
           0    0    faixa_id_seq    ACL     �   REVOKE ALL ON SEQUENCE faixa_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE faixa_id_seq FROM postgres;
GRANT ALL ON SEQUENCE faixa_id_seq TO postgres;
GRANT ALL ON SEQUENCE faixa_id_seq TO PUBLIC;
            public       postgres    false    201            �            1259    57541    grupo    TABLE     q   CREATE TABLE grupo (
    id integer NOT NULL,
    titulo character varying(255),
    status integer DEFAULT 1
);
    DROP TABLE public.grupo;
       public         postgres    false    6            �            1259    57545    grupo_id_seq    SEQUENCE     n   CREATE SEQUENCE grupo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.grupo_id_seq;
       public       postgres    false    6    202            �
           0    0    grupo_id_seq    SEQUENCE OWNED BY     /   ALTER SEQUENCE grupo_id_seq OWNED BY grupo.id;
            public       postgres    false    203            �            1259    57547 	   indicador    TABLE       CREATE TABLE indicador (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    indicador_id integer,
    faixa_id integer NOT NULL,
    objetivo_id integer NOT NULL,
    usuario_id integer NOT NULL,
    calculo integer NOT NULL,
    desdobramento integer DEFAULT 1 NOT NULL,
    projecao integer DEFAULT 0 NOT NULL,
    tipo_calculo integer DEFAULT 0 NOT NULL,
    tipo integer DEFAULT 0 NOT NULL,
    ordem integer NOT NULL,
    status integer DEFAULT 1 NOT NULL,
    anos text,
    unidade character varying(255)
);
    DROP TABLE public.indicador;
       public         postgres    false    6            �
           0    0 	   indicador    ACL     �   REVOKE ALL ON TABLE indicador FROM PUBLIC;
REVOKE ALL ON TABLE indicador FROM postgres;
GRANT ALL ON TABLE indicador TO postgres;
GRANT ALL ON TABLE indicador TO PUBLIC;
            public       postgres    false    204            �            1259    57558    indicador_autorizado_visualizar    TABLE     |   CREATE TABLE indicador_autorizado_visualizar (
    id integer NOT NULL,
    usuario_id integer,
    indicador_id integer
);
 3   DROP TABLE public.indicador_autorizado_visualizar;
       public         postgres    false    6            �
           0    0    indicador_autorizado_visualizar    ACL       REVOKE ALL ON TABLE indicador_autorizado_visualizar FROM PUBLIC;
REVOKE ALL ON TABLE indicador_autorizado_visualizar FROM postgres;
GRANT ALL ON TABLE indicador_autorizado_visualizar TO postgres;
GRANT ALL ON TABLE indicador_autorizado_visualizar TO PUBLIC;
            public       postgres    false    205            �            1259    57561 &   indicador_autorizado_visualizar_id_seq    SEQUENCE     �   CREATE SEQUENCE indicador_autorizado_visualizar_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE public.indicador_autorizado_visualizar_id_seq;
       public       postgres    false    205    6            �
           0    0 &   indicador_autorizado_visualizar_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE indicador_autorizado_visualizar_id_seq OWNED BY indicador_autorizado_visualizar.id;
            public       postgres    false    206            �
           0    0 &   indicador_autorizado_visualizar_id_seq    ACL     *  REVOKE ALL ON SEQUENCE indicador_autorizado_visualizar_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE indicador_autorizado_visualizar_id_seq FROM postgres;
GRANT ALL ON SEQUENCE indicador_autorizado_visualizar_id_seq TO postgres;
GRANT ALL ON SEQUENCE indicador_autorizado_visualizar_id_seq TO PUBLIC;
            public       postgres    false    206            �            1259    57563    indicador_id_seq    SEQUENCE     r   CREATE SEQUENCE indicador_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.indicador_id_seq;
       public       postgres    false    204    6            �
           0    0    indicador_id_seq    SEQUENCE OWNED BY     7   ALTER SEQUENCE indicador_id_seq OWNED BY indicador.id;
            public       postgres    false    207            �
           0    0    indicador_id_seq    ACL     �   REVOKE ALL ON SEQUENCE indicador_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE indicador_id_seq FROM postgres;
GRANT ALL ON SEQUENCE indicador_id_seq TO postgres;
GRANT ALL ON SEQUENCE indicador_id_seq TO PUBLIC;
            public       postgres    false    207            �            1259    57565    indicador_meta    TABLE     �  CREATE TABLE indicador_meta (
    id integer NOT NULL,
    indicador_id integer,
    janeiro double precision,
    fevereiro double precision,
    marco double precision,
    abril double precision,
    maio double precision,
    junho double precision,
    julho double precision,
    agosto double precision,
    setembro double precision,
    outubro double precision,
    novembro double precision,
    dezembro double precision,
    ano character varying
);
 "   DROP TABLE public.indicador_meta;
       public         postgres    false    6            �
           0    0    indicador_meta    ACL     �   REVOKE ALL ON TABLE indicador_meta FROM PUBLIC;
REVOKE ALL ON TABLE indicador_meta FROM postgres;
GRANT ALL ON TABLE indicador_meta TO postgres;
GRANT ALL ON TABLE indicador_meta TO PUBLIC;
            public       postgres    false    208            �            1259    57571    indicador_meta_id_seq    SEQUENCE     w   CREATE SEQUENCE indicador_meta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.indicador_meta_id_seq;
       public       postgres    false    6    208            �
           0    0    indicador_meta_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE indicador_meta_id_seq OWNED BY indicador_meta.id;
            public       postgres    false    209            �
           0    0    indicador_meta_id_seq    ACL     �   REVOKE ALL ON SEQUENCE indicador_meta_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE indicador_meta_id_seq FROM postgres;
GRANT ALL ON SEQUENCE indicador_meta_id_seq TO postgres;
GRANT ALL ON SEQUENCE indicador_meta_id_seq TO PUBLIC;
            public       postgres    false    209            �            1259    57573    indicador_realizado    TABLE     �  CREATE TABLE indicador_realizado (
    id integer NOT NULL,
    indicador_id integer,
    janeiro double precision,
    fevereiro double precision,
    marco double precision,
    abril double precision,
    maio double precision,
    junho double precision,
    julho double precision,
    agosto double precision,
    setembro double precision,
    outubro double precision,
    novembro double precision,
    dezembro double precision,
    ano character varying
);
 '   DROP TABLE public.indicador_realizado;
       public         postgres    false    6            �
           0    0    indicador_realizado    ACL     �   REVOKE ALL ON TABLE indicador_realizado FROM PUBLIC;
REVOKE ALL ON TABLE indicador_realizado FROM postgres;
GRANT ALL ON TABLE indicador_realizado TO postgres;
GRANT ALL ON TABLE indicador_realizado TO PUBLIC;
            public       postgres    false    210            �            1259    57579    indicador_realizado_id_seq    SEQUENCE     |   CREATE SEQUENCE indicador_realizado_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.indicador_realizado_id_seq;
       public       postgres    false    210    6            �
           0    0    indicador_realizado_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE indicador_realizado_id_seq OWNED BY indicador_realizado.id;
            public       postgres    false    211            �
           0    0    indicador_realizado_id_seq    ACL     �   REVOKE ALL ON SEQUENCE indicador_realizado_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE indicador_realizado_id_seq FROM postgres;
GRANT ALL ON SEQUENCE indicador_realizado_id_seq TO postgres;
GRANT ALL ON SEQUENCE indicador_realizado_id_seq TO PUBLIC;
            public       postgres    false    211            �            1259    57581    indicador_responsavel_meta    TABLE     w   CREATE TABLE indicador_responsavel_meta (
    id integer NOT NULL,
    usuario_id integer,
    indicador_id integer
);
 .   DROP TABLE public.indicador_responsavel_meta;
       public         postgres    false    6            �
           0    0 .   COLUMN indicador_responsavel_meta.indicador_id    COMMENT     B   COMMENT ON COLUMN indicador_responsavel_meta.indicador_id IS '
';
            public       postgres    false    212            �
           0    0    indicador_responsavel_meta    ACL     �   REVOKE ALL ON TABLE indicador_responsavel_meta FROM PUBLIC;
REVOKE ALL ON TABLE indicador_responsavel_meta FROM postgres;
GRANT ALL ON TABLE indicador_responsavel_meta TO postgres;
GRANT ALL ON TABLE indicador_responsavel_meta TO PUBLIC;
            public       postgres    false    212            �            1259    57584 !   indicador_responsavel_meta_id_seq    SEQUENCE     �   CREATE SEQUENCE indicador_responsavel_meta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE public.indicador_responsavel_meta_id_seq;
       public       postgres    false    212    6            �
           0    0 !   indicador_responsavel_meta_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE indicador_responsavel_meta_id_seq OWNED BY indicador_responsavel_meta.id;
            public       postgres    false    213            �
           0    0 !   indicador_responsavel_meta_id_seq    ACL       REVOKE ALL ON SEQUENCE indicador_responsavel_meta_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE indicador_responsavel_meta_id_seq FROM postgres;
GRANT ALL ON SEQUENCE indicador_responsavel_meta_id_seq TO postgres;
GRANT ALL ON SEQUENCE indicador_responsavel_meta_id_seq TO PUBLIC;
            public       postgres    false    213            �            1259    57586    indicador_responsavel_realizado    TABLE     |   CREATE TABLE indicador_responsavel_realizado (
    id integer NOT NULL,
    usuario_id integer,
    indicador_id integer
);
 3   DROP TABLE public.indicador_responsavel_realizado;
       public         postgres    false    6            �
           0    0    indicador_responsavel_realizado    ACL       REVOKE ALL ON TABLE indicador_responsavel_realizado FROM PUBLIC;
REVOKE ALL ON TABLE indicador_responsavel_realizado FROM postgres;
GRANT ALL ON TABLE indicador_responsavel_realizado TO postgres;
GRANT ALL ON TABLE indicador_responsavel_realizado TO PUBLIC;
            public       postgres    false    214            �            1259    57589 &   indicador_responsavel_realizado_id_seq    SEQUENCE     �   CREATE SEQUENCE indicador_responsavel_realizado_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 =   DROP SEQUENCE public.indicador_responsavel_realizado_id_seq;
       public       postgres    false    214    6            �
           0    0 &   indicador_responsavel_realizado_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE indicador_responsavel_realizado_id_seq OWNED BY indicador_responsavel_realizado.id;
            public       postgres    false    215            �
           0    0 &   indicador_responsavel_realizado_id_seq    ACL     *  REVOKE ALL ON SEQUENCE indicador_responsavel_realizado_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE indicador_responsavel_realizado_id_seq FROM postgres;
GRANT ALL ON SEQUENCE indicador_responsavel_realizado_id_seq TO postgres;
GRANT ALL ON SEQUENCE indicador_responsavel_realizado_id_seq TO PUBLIC;
            public       postgres    false    215            �            1259    57591    objetivo    TABLE     �   CREATE TABLE objetivo (
    id integer NOT NULL,
    ano integer,
    ordem integer,
    titulo character varying(255),
    dimensao_id integer,
    status integer DEFAULT 1,
    tipo integer DEFAULT 1,
    objetivo_id integer
);
    DROP TABLE public.objetivo;
       public         postgres    false    6            �            1259    57596    objetivo_id_seq    SEQUENCE     q   CREATE SEQUENCE objetivo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.objetivo_id_seq;
       public       postgres    false    216    6            �
           0    0    objetivo_id_seq    SEQUENCE OWNED BY     5   ALTER SEQUENCE objetivo_id_seq OWNED BY objetivo.id;
            public       postgres    false    217            �            1259    57598    objetivo_projeto    TABLE     l   CREATE TABLE objetivo_projeto (
    id integer NOT NULL,
    projeto_id integer,
    objetivo_id integer
);
 $   DROP TABLE public.objetivo_projeto;
       public         postgres    false    6            �            1259    57601    objetivo_projeto_id_seq    SEQUENCE     y   CREATE SEQUENCE objetivo_projeto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.objetivo_projeto_id_seq;
       public       postgres    false    6    218            �
           0    0    objetivo_projeto_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE objetivo_projeto_id_seq OWNED BY objetivo_projeto.id;
            public       postgres    false    219            �            1259    57603    pessoa    TABLE     �   CREATE TABLE pessoa (
    id integer NOT NULL,
    titulo character varying(255),
    tipo character(2),
    observacao text,
    email character varying(255)
);
    DROP TABLE public.pessoa;
       public         postgres    false    6            �            1259    57609    pessoa_comunicacao    TABLE     p   CREATE TABLE pessoa_comunicacao (
    id integer NOT NULL,
    pessoa_id integer,
    comunicacao_id integer
);
 &   DROP TABLE public.pessoa_comunicacao;
       public         postgres    false    6            �            1259    57612    pessoa_comunicacao_id_seq    SEQUENCE     {   CREATE SEQUENCE pessoa_comunicacao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.pessoa_comunicacao_id_seq;
       public       postgres    false    6    221            �
           0    0    pessoa_comunicacao_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE pessoa_comunicacao_id_seq OWNED BY pessoa_comunicacao.id;
            public       postgres    false    222            �            1259    57614    pessoa_id_seq    SEQUENCE     o   CREATE SEQUENCE pessoa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.pessoa_id_seq;
       public       postgres    false    6    220            �
           0    0    pessoa_id_seq    SEQUENCE OWNED BY     1   ALTER SEQUENCE pessoa_id_seq OWNED BY pessoa.id;
            public       postgres    false    223            �            1259    57616 
   plano_acao    TABLE     �   CREATE TABLE plano_acao (
    id integer NOT NULL,
    objetivo_id integer,
    titulo character varying(255),
    status integer DEFAULT 1
);
    DROP TABLE public.plano_acao;
       public         postgres    false    6            �            1259    57620    plano_acao_id_seq    SEQUENCE     s   CREATE SEQUENCE plano_acao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.plano_acao_id_seq;
       public       postgres    false    6    224            �
           0    0    plano_acao_id_seq    SEQUENCE OWNED BY     9   ALTER SEQUENCE plano_acao_id_seq OWNED BY plano_acao.id;
            public       postgres    false    225            �            1259    57622    plano_acao_projeto    TABLE     p   CREATE TABLE plano_acao_projeto (
    id integer NOT NULL,
    projeto_id integer,
    plano_acao_id integer
);
 &   DROP TABLE public.plano_acao_projeto;
       public         postgres    false    6            �            1259    57625    plano_acao_projeto_id_seq    SEQUENCE     {   CREATE SEQUENCE plano_acao_projeto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.plano_acao_projeto_id_seq;
       public       postgres    false    226    6            �
           0    0    plano_acao_projeto_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE plano_acao_projeto_id_seq OWNED BY plano_acao_projeto.id;
            public       postgres    false    227            �            1259    57627    post    TABLE     n  CREATE TABLE post (
    id integer NOT NULL,
    titulo character varying(255),
    mensagem text,
    acao_id integer,
    receber_email integer DEFAULT 1,
    status integer DEFAULT 1,
    post_id integer,
    created timestamp without time zone,
    modified timestamp without time zone,
    usuario_id integer,
    categoria_id integer,
    tarefa_id integer
);
    DROP TABLE public.post;
       public         postgres    false    6            �
           0    0    post    ACL     �   REVOKE ALL ON TABLE post FROM PUBLIC;
REVOKE ALL ON TABLE post FROM postgres;
GRANT ALL ON TABLE post TO postgres;
GRANT ALL ON TABLE post TO PUBLIC;
            public       postgres    false    228            �            1259    57635    post_id_seq    SEQUENCE     m   CREATE SEQUENCE post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.post_id_seq;
       public       postgres    false    228    6            �
           0    0    post_id_seq    SEQUENCE OWNED BY     -   ALTER SEQUENCE post_id_seq OWNED BY post.id;
            public       postgres    false    229            �
           0    0    post_id_seq    ACL     �   REVOKE ALL ON SEQUENCE post_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE post_id_seq FROM postgres;
GRANT ALL ON SEQUENCE post_id_seq TO postgres;
GRANT ALL ON SEQUENCE post_id_seq TO PUBLIC;
            public       postgres    false    229            �            1259    57637    procedimento    TABLE     7  CREATE TABLE procedimento (
    id integer NOT NULL,
    titulo character varying(255),
    resultado_esperado text,
    passos text,
    requisito text,
    arquivo character varying(255),
    arquivo_dir character varying(255),
    usuario_id integer,
    certificado integer,
    status integer DEFAULT 1
);
     DROP TABLE public.procedimento;
       public         postgres    false    6            �
           0    0    procedimento    ACL     �   REVOKE ALL ON TABLE procedimento FROM PUBLIC;
REVOKE ALL ON TABLE procedimento FROM postgres;
GRANT ALL ON TABLE procedimento TO postgres;
GRANT ALL ON TABLE procedimento TO PUBLIC;
            public       postgres    false    230            �            1259    57644    procedimento_id_seq    SEQUENCE     u   CREATE SEQUENCE procedimento_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.procedimento_id_seq;
       public       postgres    false    230    6            �
           0    0    procedimento_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE procedimento_id_seq OWNED BY procedimento.id;
            public       postgres    false    231            �
           0    0    procedimento_id_seq    ACL     �   REVOKE ALL ON SEQUENCE procedimento_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE procedimento_id_seq FROM postgres;
GRANT ALL ON SEQUENCE procedimento_id_seq TO postgres;
GRANT ALL ON SEQUENCE procedimento_id_seq TO PUBLIC;
            public       postgres    false    231            �            1259    57646    projeto    TABLE     �  CREATE TABLE projeto (
    id integer NOT NULL,
    titulo character varying(255),
    data_inicio_previsto date,
    data_fim_previsto date,
    valor double precision,
    descricao text,
    concluido integer DEFAULT 0,
    data_conclusao date,
    motivacao text,
    resultado text,
    risco text,
    usuario_id integer,
    status integer DEFAULT 1,
    custo double precision,
    moeda character varying(10)
);
    DROP TABLE public.projeto;
       public         postgres    false    6            �            1259    57654    projeto_id_seq    SEQUENCE     p   CREATE SEQUENCE projeto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.projeto_id_seq;
       public       postgres    false    6    232                        0    0    projeto_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE projeto_id_seq OWNED BY projeto.id;
            public       postgres    false    233            �            1259    57656    reuniao    TABLE     X  CREATE TABLE reuniao (
    id integer NOT NULL,
    titulo character varying(255),
    projeto_id integer,
    data date,
    pauta text,
    ata text,
    observacao text,
    convidados_externos text,
    local character varying(255),
    status integer DEFAULT 1,
    hora_inicio character varying(10),
    hora_fim character varying(10)
);
    DROP TABLE public.reuniao;
       public         postgres    false    6                       0    0    reuniao    ACL     �   REVOKE ALL ON TABLE reuniao FROM PUBLIC;
REVOKE ALL ON TABLE reuniao FROM postgres;
GRANT ALL ON TABLE reuniao TO postgres;
GRANT ALL ON TABLE reuniao TO PUBLIC;
            public       postgres    false    234            �            1259    57663    reuniao_conhecedor    TABLE     m   CREATE TABLE reuniao_conhecedor (
    id integer NOT NULL,
    reuniao_id integer,
    usuario_id integer
);
 &   DROP TABLE public.reuniao_conhecedor;
       public         postgres    false    6                       0    0    reuniao_conhecedor    ACL     �   REVOKE ALL ON TABLE reuniao_conhecedor FROM PUBLIC;
REVOKE ALL ON TABLE reuniao_conhecedor FROM postgres;
GRANT ALL ON TABLE reuniao_conhecedor TO postgres;
GRANT ALL ON TABLE reuniao_conhecedor TO PUBLIC;
            public       postgres    false    235            �            1259    57666    reuniao_conhecedor_id_seq    SEQUENCE     {   CREATE SEQUENCE reuniao_conhecedor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.reuniao_conhecedor_id_seq;
       public       postgres    false    6    235                       0    0    reuniao_conhecedor_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE reuniao_conhecedor_id_seq OWNED BY reuniao_conhecedor.id;
            public       postgres    false    236                       0    0    reuniao_conhecedor_id_seq    ACL     �   REVOKE ALL ON SEQUENCE reuniao_conhecedor_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE reuniao_conhecedor_id_seq FROM postgres;
GRANT ALL ON SEQUENCE reuniao_conhecedor_id_seq TO postgres;
GRANT ALL ON SEQUENCE reuniao_conhecedor_id_seq TO PUBLIC;
            public       postgres    false    236            �            1259    57668    reuniao_email_externo    TABLE     z   CREATE TABLE reuniao_email_externo (
    id integer NOT NULL,
    reuniao_id integer,
    email character varying(255)
);
 )   DROP TABLE public.reuniao_email_externo;
       public         postgres    false    6                       0    0    reuniao_email_externo    ACL     �   REVOKE ALL ON TABLE reuniao_email_externo FROM PUBLIC;
REVOKE ALL ON TABLE reuniao_email_externo FROM postgres;
GRANT ALL ON TABLE reuniao_email_externo TO postgres;
GRANT ALL ON TABLE reuniao_email_externo TO PUBLIC;
            public       postgres    false    237            �            1259    57671    reuniao_email_externo_id_seq    SEQUENCE     ~   CREATE SEQUENCE reuniao_email_externo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.reuniao_email_externo_id_seq;
       public       postgres    false    237    6                       0    0    reuniao_email_externo_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE reuniao_email_externo_id_seq OWNED BY reuniao_email_externo.id;
            public       postgres    false    238                       0    0    reuniao_email_externo_id_seq    ACL       REVOKE ALL ON SEQUENCE reuniao_email_externo_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE reuniao_email_externo_id_seq FROM postgres;
GRANT ALL ON SEQUENCE reuniao_email_externo_id_seq TO postgres;
GRANT ALL ON SEQUENCE reuniao_email_externo_id_seq TO PUBLIC;
            public       postgres    false    238            �            1259    57673    reuniao_id_seq    SEQUENCE     p   CREATE SEQUENCE reuniao_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.reuniao_id_seq;
       public       postgres    false    234    6                       0    0    reuniao_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE reuniao_id_seq OWNED BY reuniao.id;
            public       postgres    false    239            	           0    0    reuniao_id_seq    ACL     �   REVOKE ALL ON SEQUENCE reuniao_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE reuniao_id_seq FROM postgres;
GRANT ALL ON SEQUENCE reuniao_id_seq TO postgres;
GRANT ALL ON SEQUENCE reuniao_id_seq TO PUBLIC;
            public       postgres    false    239            �            1259    57675    reuniao_participante    TABLE     o   CREATE TABLE reuniao_participante (
    id integer NOT NULL,
    reuniao_id integer,
    usuario_id integer
);
 (   DROP TABLE public.reuniao_participante;
       public         postgres    false    6            
           0    0    reuniao_participante    ACL     �   REVOKE ALL ON TABLE reuniao_participante FROM PUBLIC;
REVOKE ALL ON TABLE reuniao_participante FROM postgres;
GRANT ALL ON TABLE reuniao_participante TO postgres;
GRANT ALL ON TABLE reuniao_participante TO PUBLIC;
            public       postgres    false    240            �            1259    57678    reuniao_participante_id_seq    SEQUENCE     }   CREATE SEQUENCE reuniao_participante_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.reuniao_participante_id_seq;
       public       postgres    false    240    6                       0    0    reuniao_participante_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE reuniao_participante_id_seq OWNED BY reuniao_participante.id;
            public       postgres    false    241                       0    0    reuniao_participante_id_seq    ACL     �   REVOKE ALL ON SEQUENCE reuniao_participante_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE reuniao_participante_id_seq FROM postgres;
GRANT ALL ON SEQUENCE reuniao_participante_id_seq TO postgres;
GRANT ALL ON SEQUENCE reuniao_participante_id_seq TO PUBLIC;
            public       postgres    false    241            �            1259    57680    setor    TABLE     �   CREATE TABLE setor (
    id integer NOT NULL,
    titulo character varying(255),
    status integer DEFAULT 1,
    tipo integer
);
    DROP TABLE public.setor;
       public         postgres    false    6                       0    0    setor    ACL     �   REVOKE ALL ON TABLE setor FROM PUBLIC;
REVOKE ALL ON TABLE setor FROM postgres;
GRANT ALL ON TABLE setor TO postgres;
GRANT ALL ON TABLE setor TO PUBLIC;
            public       postgres    false    242            �            1259    57684    setor_id_seq    SEQUENCE     n   CREATE SEQUENCE setor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.setor_id_seq;
       public       postgres    false    242    6                       0    0    setor_id_seq    SEQUENCE OWNED BY     /   ALTER SEQUENCE setor_id_seq OWNED BY setor.id;
            public       postgres    false    243                       0    0    setor_id_seq    ACL     �   REVOKE ALL ON SEQUENCE setor_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE setor_id_seq FROM postgres;
GRANT ALL ON SEQUENCE setor_id_seq TO postgres;
GRANT ALL ON SEQUENCE setor_id_seq TO PUBLIC;
            public       postgres    false    243            �            1259    57686    tarefa    TABLE     �  CREATE TABLE tarefa (
    id integer NOT NULL,
    titulo character varying(255),
    data_inicio_previsto date,
    data_fim_previsto date,
    concluido integer DEFAULT 0,
    data_conclusao date,
    status integer DEFAULT 1,
    comentario text,
    lembrete date,
    arquivo character varying(255),
    arquivo_dir character varying(255),
    responsavel_id integer,
    supervisor_id integer,
    prioridade character varying(10),
    reuniao_id integer,
    acao_id integer
);
    DROP TABLE public.tarefa;
       public         postgres    false    6                       0    0    tarefa    ACL     �   REVOKE ALL ON TABLE tarefa FROM PUBLIC;
REVOKE ALL ON TABLE tarefa FROM postgres;
GRANT ALL ON TABLE tarefa TO postgres;
GRANT ALL ON TABLE tarefa TO PUBLIC;
            public       postgres    false    244            �            1259    57694    terefa_id_seq    SEQUENCE     o   CREATE SEQUENCE terefa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.terefa_id_seq;
       public       postgres    false    244    6                       0    0    terefa_id_seq    SEQUENCE OWNED BY     1   ALTER SEQUENCE terefa_id_seq OWNED BY tarefa.id;
            public       postgres    false    245                       0    0    terefa_id_seq    ACL     �   REVOKE ALL ON SEQUENCE terefa_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE terefa_id_seq FROM postgres;
GRANT ALL ON SEQUENCE terefa_id_seq TO postgres;
GRANT ALL ON SEQUENCE terefa_id_seq TO PUBLIC;
            public       postgres    false    245            �            1259    57696    usuario    TABLE     S  CREATE TABLE usuario (
    id integer NOT NULL,
    login character varying(255),
    senha character varying(50),
    status integer DEFAULT 1,
    lembrete_senha character varying(255),
    foto character varying(255),
    enviado integer,
    pessoa_id integer,
    cargo_id integer,
    vinculo_id integer,
    cpf character varying(45),
    rg character varying(45),
    grupo_id integer,
    departamento_id integer,
    setor_id integer,
    chefe integer DEFAULT 0,
    imagem_perfil character varying(255),
    diretorio_imagem_perfil character varying(255),
    endereco_id integer
);
    DROP TABLE public.usuario;
       public         postgres    false    6            �            1259    57704    usuario_id_seq    SEQUENCE     p   CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.usuario_id_seq;
       public       postgres    false    246    6                       0    0    usuario_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE usuario_id_seq OWNED BY usuario.id;
            public       postgres    false    247            �            1259    57706    vinculo    TABLE     �   CREATE TABLE vinculo (
    id integer NOT NULL,
    titulo character varying(255),
    status integer DEFAULT 1,
    created timestamp without time zone,
    modified timestamp without time zone
);
    DROP TABLE public.vinculo;
       public         postgres    false    6            �            1259    57710    vinculo_id_seq    SEQUENCE     p   CREATE SEQUENCE vinculo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.vinculo_id_seq;
       public       postgres    false    248    6                       0    0    vinculo_id_seq    SEQUENCE OWNED BY     3   ALTER SEQUENCE vinculo_id_seq OWNED BY vinculo.id;
            public       postgres    false    249            �	           2604    57712    id    DEFAULT     T   ALTER TABLE ONLY acao ALTER COLUMN id SET DEFAULT nextval('acao_id_seq'::regclass);
 6   ALTER TABLE public.acao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    169    168            �	           2604    57713    id    DEFAULT     j   ALTER TABLE ONLY acao_plano_acao ALTER COLUMN id SET DEFAULT nextval('acao_plano_acao_id_seq'::regclass);
 A   ALTER TABLE public.acao_plano_acao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    171    170            �	           2604    57714    id    DEFAULT     T   ALTER TABLE ONLY acos ALTER COLUMN id SET DEFAULT nextval('acos_id_seq'::regclass);
 6   ALTER TABLE public.acos ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    173    172            �	           2604    57715    id    DEFAULT     \   ALTER TABLE ONLY anomalia ALTER COLUMN id SET DEFAULT nextval('anomalia_id_seq'::regclass);
 :   ALTER TABLE public.anomalia ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    175    174            �	           2604    57716    id    DEFAULT     T   ALTER TABLE ONLY aros ALTER COLUMN id SET DEFAULT nextval('aros_id_seq'::regclass);
 6   ALTER TABLE public.aros ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    179    176            �	           2604    57717    id    DEFAULT     ^   ALTER TABLE ONLY aros_acos ALTER COLUMN id SET DEFAULT nextval('aros_acos_id_seq'::regclass);
 ;   ALTER TABLE public.aros_acos ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    178    177            �	           2604    57718    id    DEFAULT     ^   ALTER TABLE ONLY auditoria ALTER COLUMN id SET DEFAULT nextval('auditoria_id_seq'::regclass);
 ;   ALTER TABLE public.auditoria ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    183    180            �	           2604    57719    id    DEFAULT     l   ALTER TABLE ONLY auditoria_campos ALTER COLUMN id SET DEFAULT nextval('auditoria_campos_id_seq'::regclass);
 B   ALTER TABLE public.auditoria_campos ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    182    181            �	           2604    57720    id    DEFAULT     V   ALTER TABLE ONLY cargo ALTER COLUMN id SET DEFAULT nextval('cargo_id_seq'::regclass);
 7   ALTER TABLE public.cargo ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    185    184            �	           2604    57721    id    DEFAULT     ^   ALTER TABLE ONLY categoria ALTER COLUMN id SET DEFAULT nextval('categoria_id_seq'::regclass);
 ;   ALTER TABLE public.categoria ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    187    186            �	           2604    57722    id    DEFAULT     `   ALTER TABLE ONLY comentario ALTER COLUMN id SET DEFAULT nextval('comentario_id_seq'::regclass);
 <   ALTER TABLE public.comentario ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    189    188            �	           2604    57723    id    DEFAULT     b   ALTER TABLE ONLY comunicacao ALTER COLUMN id SET DEFAULT nextval('comunicacao_id_seq'::regclass);
 =   ALTER TABLE public.comunicacao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    191    190            �	           2604    57724    id    DEFAULT     d   ALTER TABLE ONLY departamento ALTER COLUMN id SET DEFAULT nextval('departamento_id_seq'::regclass);
 >   ALTER TABLE public.departamento ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    193    192            �	           2604    57725    id    DEFAULT     \   ALTER TABLE ONLY dimensao ALTER COLUMN id SET DEFAULT nextval('dimensao_id_seq'::regclass);
 :   ALTER TABLE public.dimensao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    195    194            �	           2604    57726    id    DEFAULT     Z   ALTER TABLE ONLY empresa ALTER COLUMN id SET DEFAULT nextval('empresa_id_seq'::regclass);
 9   ALTER TABLE public.empresa ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    197    196            �	           2604    57727    id    DEFAULT     \   ALTER TABLE ONLY endereco ALTER COLUMN id SET DEFAULT nextval('endereco_id_seq'::regclass);
 :   ALTER TABLE public.endereco ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    199    198            �	           2604    57728    id    DEFAULT     V   ALTER TABLE ONLY faixa ALTER COLUMN id SET DEFAULT nextval('faixa_id_seq'::regclass);
 7   ALTER TABLE public.faixa ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    201    200            �	           2604    57729    id    DEFAULT     V   ALTER TABLE ONLY grupo ALTER COLUMN id SET DEFAULT nextval('grupo_id_seq'::regclass);
 7   ALTER TABLE public.grupo ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    203    202            �	           2604    57730    id    DEFAULT     ^   ALTER TABLE ONLY indicador ALTER COLUMN id SET DEFAULT nextval('indicador_id_seq'::regclass);
 ;   ALTER TABLE public.indicador ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    207    204            �	           2604    57731    id    DEFAULT     �   ALTER TABLE ONLY indicador_autorizado_visualizar ALTER COLUMN id SET DEFAULT nextval('indicador_autorizado_visualizar_id_seq'::regclass);
 Q   ALTER TABLE public.indicador_autorizado_visualizar ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    206    205            �	           2604    57732    id    DEFAULT     h   ALTER TABLE ONLY indicador_meta ALTER COLUMN id SET DEFAULT nextval('indicador_meta_id_seq'::regclass);
 @   ALTER TABLE public.indicador_meta ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    209    208            �	           2604    57733    id    DEFAULT     r   ALTER TABLE ONLY indicador_realizado ALTER COLUMN id SET DEFAULT nextval('indicador_realizado_id_seq'::regclass);
 E   ALTER TABLE public.indicador_realizado ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    211    210            �	           2604    57734    id    DEFAULT     �   ALTER TABLE ONLY indicador_responsavel_meta ALTER COLUMN id SET DEFAULT nextval('indicador_responsavel_meta_id_seq'::regclass);
 L   ALTER TABLE public.indicador_responsavel_meta ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    213    212            �	           2604    57735    id    DEFAULT     �   ALTER TABLE ONLY indicador_responsavel_realizado ALTER COLUMN id SET DEFAULT nextval('indicador_responsavel_realizado_id_seq'::regclass);
 Q   ALTER TABLE public.indicador_responsavel_realizado ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    215    214            �	           2604    57736    id    DEFAULT     \   ALTER TABLE ONLY objetivo ALTER COLUMN id SET DEFAULT nextval('objetivo_id_seq'::regclass);
 :   ALTER TABLE public.objetivo ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    217    216            �	           2604    57737    id    DEFAULT     l   ALTER TABLE ONLY objetivo_projeto ALTER COLUMN id SET DEFAULT nextval('objetivo_projeto_id_seq'::regclass);
 B   ALTER TABLE public.objetivo_projeto ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    219    218            �	           2604    57738    id    DEFAULT     X   ALTER TABLE ONLY pessoa ALTER COLUMN id SET DEFAULT nextval('pessoa_id_seq'::regclass);
 8   ALTER TABLE public.pessoa ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    223    220            �	           2604    57739    id    DEFAULT     p   ALTER TABLE ONLY pessoa_comunicacao ALTER COLUMN id SET DEFAULT nextval('pessoa_comunicacao_id_seq'::regclass);
 D   ALTER TABLE public.pessoa_comunicacao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    222    221            �	           2604    57740    id    DEFAULT     `   ALTER TABLE ONLY plano_acao ALTER COLUMN id SET DEFAULT nextval('plano_acao_id_seq'::regclass);
 <   ALTER TABLE public.plano_acao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    225    224            �	           2604    57741    id    DEFAULT     p   ALTER TABLE ONLY plano_acao_projeto ALTER COLUMN id SET DEFAULT nextval('plano_acao_projeto_id_seq'::regclass);
 D   ALTER TABLE public.plano_acao_projeto ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    227    226            �	           2604    57742    id    DEFAULT     T   ALTER TABLE ONLY post ALTER COLUMN id SET DEFAULT nextval('post_id_seq'::regclass);
 6   ALTER TABLE public.post ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    229    228            �	           2604    57743    id    DEFAULT     d   ALTER TABLE ONLY procedimento ALTER COLUMN id SET DEFAULT nextval('procedimento_id_seq'::regclass);
 >   ALTER TABLE public.procedimento ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    231    230            �	           2604    57744    id    DEFAULT     Z   ALTER TABLE ONLY projeto ALTER COLUMN id SET DEFAULT nextval('projeto_id_seq'::regclass);
 9   ALTER TABLE public.projeto ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    233    232            �	           2604    57745    id    DEFAULT     Z   ALTER TABLE ONLY reuniao ALTER COLUMN id SET DEFAULT nextval('reuniao_id_seq'::regclass);
 9   ALTER TABLE public.reuniao ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    239    234            �	           2604    57746    id    DEFAULT     p   ALTER TABLE ONLY reuniao_conhecedor ALTER COLUMN id SET DEFAULT nextval('reuniao_conhecedor_id_seq'::regclass);
 D   ALTER TABLE public.reuniao_conhecedor ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    236    235            �	           2604    57747    id    DEFAULT     v   ALTER TABLE ONLY reuniao_email_externo ALTER COLUMN id SET DEFAULT nextval('reuniao_email_externo_id_seq'::regclass);
 G   ALTER TABLE public.reuniao_email_externo ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    238    237            �	           2604    57748    id    DEFAULT     t   ALTER TABLE ONLY reuniao_participante ALTER COLUMN id SET DEFAULT nextval('reuniao_participante_id_seq'::regclass);
 F   ALTER TABLE public.reuniao_participante ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    241    240            �	           2604    57749    id    DEFAULT     V   ALTER TABLE ONLY setor ALTER COLUMN id SET DEFAULT nextval('setor_id_seq'::regclass);
 7   ALTER TABLE public.setor ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    243    242            �	           2604    57750    id    DEFAULT     X   ALTER TABLE ONLY tarefa ALTER COLUMN id SET DEFAULT nextval('terefa_id_seq'::regclass);
 8   ALTER TABLE public.tarefa ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    245    244            �	           2604    57751    id    DEFAULT     Z   ALTER TABLE ONLY usuario ALTER COLUMN id SET DEFAULT nextval('usuario_id_seq'::regclass);
 9   ALTER TABLE public.usuario ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    247    246            �	           2604    57752    id    DEFAULT     Z   ALTER TABLE ONLY vinculo ALTER COLUMN id SET DEFAULT nextval('vinculo_id_seq'::regclass);
 9   ALTER TABLE public.vinculo ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    249    248            k
          0    57402    acao 
   TABLE DATA               �   COPY acao (id, titulo, data_inicio_previsto, data_fim_previsto, concluido, data_conclusao, status, observacao, lembrete, andamento, responsavel_id, acao_id, supervisor_id, prioridade, anomalia_id, objetivo_id, projeto_id, marco, ordem) FROM stdin;
    public       postgres    false    168   ��                 0    0    acao_id_seq    SEQUENCE SET     4   SELECT pg_catalog.setval('acao_id_seq', 100, true);
            public       postgres    false    169            m
          0    57412    acao_plano_acao 
   TABLE DATA               >   COPY acao_plano_acao (id, plano_acao_id, acao_id) FROM stdin;
    public       postgres    false    170   �                 0    0    acao_plano_acao_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('acao_plano_acao_id_seq', 6, true);
            public       postgres    false    171            o
          0    57417    acos 
   TABLE DATA               L   COPY acos (id, parent_id, model, foreign_key, alias, lft, rght) FROM stdin;
    public       postgres    false    172   $�                 0    0    acos_id_seq    SEQUENCE SET     3   SELECT pg_catalog.setval('acos_id_seq', 74, true);
            public       postgres    false    173            q
          0    57427    anomalia 
   TABLE DATA               �   COPY anomalia (id, causas_internas, causas_externas, data, indicador_id, status, data_conclusao, identificacao_problema, estratificacao_problema, concluido) FROM stdin;
    public       postgres    false    174   ��                 0    0    anomalia_id_seq    SEQUENCE SET     7   SELECT pg_catalog.setval('anomalia_id_seq', 14, true);
            public       postgres    false    175            s
          0    57436    aros 
   TABLE DATA               L   COPY aros (id, parent_id, model, foreign_key, alias, lft, rght) FROM stdin;
    public       postgres    false    176   ��      t
          0    57444 	   aros_acos 
   TABLE DATA               R   COPY aros_acos (id, aro_id, aco_id, _create, _read, _update, _delete) FROM stdin;
    public       postgres    false    177   ��                 0    0    aros_acos_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('aros_acos_id_seq', 2936, true);
            public       postgres    false    178                       0    0    aros_id_seq    SEQUENCE SET     3   SELECT pg_catalog.setval('aros_id_seq', 68, true);
            public       postgres    false    179            w
          0    57455 	   auditoria 
   TABLE DATA               `   COPY auditoria (id, alias_controller, alias_acao, usuario_id, created, elemento_id) FROM stdin;
    public       postgres    false    180   K�      x
          0    57461    auditoria_campos 
   TABLE DATA               h   COPY auditoria_campos (id, alias_model, valor_antigo, valor_novo, auditoria_id, tipo_campo) FROM stdin;
    public       postgres    false    181   ��                 0    0    auditoria_campos_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('auditoria_campos_id_seq', 1018, true);
            public       postgres    false    182                       0    0    auditoria_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('auditoria_id_seq', 515, true);
            public       postgres    false    183            {
          0    57471    cargo 
   TABLE DATA               7   COPY cargo (id, titulo, descricao, status) FROM stdin;
    public       postgres    false    184   �e                 0    0    cargo_id_seq    SEQUENCE SET     4   SELECT pg_catalog.setval('cargo_id_seq', 13, true);
            public       postgres    false    185            }
          0    57480 	   categoria 
   TABLE DATA               (   COPY categoria (id, titulo) FROM stdin;
    public       postgres    false    186   �f                 0    0    categoria_id_seq    SEQUENCE SET     7   SELECT pg_catalog.setval('categoria_id_seq', 3, true);
            public       postgres    false    187            
          0    57488 
   comentario 
   TABLE DATA               I   COPY comentario (id, mensagem, arquivo, usuario_id, acao_id) FROM stdin;
    public       postgres    false    188   �f                 0    0    comentario_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('comentario_id_seq', 1, false);
            public       postgres    false    189            �
          0    57496    comunicacao 
   TABLE DATA               8   COPY comunicacao (id, titulo, status, tipo) FROM stdin;
    public       postgres    false    190   g                  0    0    comunicacao_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('comunicacao_id_seq', 1, false);
            public       postgres    false    191            �
          0    57502    departamento 
   TABLE DATA               3   COPY departamento (id, titulo, status) FROM stdin;
    public       postgres    false    192   5g      !           0    0    departamento_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('departamento_id_seq', 7, true);
            public       postgres    false    193            �
          0    57508    dimensao 
   TABLE DATA               N   COPY dimensao (id, titulo, observacao, ordem, status, empresa_id) FROM stdin;
    public       postgres    false    194   �g      "           0    0    dimensao_id_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('dimensao_id_seq', 2, true);
            public       postgres    false    195            �
          0    57517    empresa 
   TABLE DATA               t   COPY empresa (id, matriz, cnpj, inscricao_estadual, inscricao_municipal, pessoa_id, empresa_id, status) FROM stdin;
    public       postgres    false    196    h      #           0    0    empresa_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('empresa_id_seq', 2, true);
            public       postgres    false    197            �
          0    57526    endereco 
   TABLE DATA               T   COPY endereco (id, logradouro, cep, bairro, cidade, numero, uf, status) FROM stdin;
    public       postgres    false    198   Gh      $           0    0    endereco_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('endereco_id_seq', 147, true);
            public       postgres    false    199            �
          0    57535    faixa 
   TABLE DATA               M   COPY faixa (id, titulo, limite_vermelho, limite_amarelo, status) FROM stdin;
    public       postgres    false    200   tk      %           0    0    faixa_id_seq    SEQUENCE SET     3   SELECT pg_catalog.setval('faixa_id_seq', 1, true);
            public       postgres    false    201            �
          0    57541    grupo 
   TABLE DATA               ,   COPY grupo (id, titulo, status) FROM stdin;
    public       postgres    false    202   �k      &           0    0    grupo_id_seq    SEQUENCE SET     4   SELECT pg_catalog.setval('grupo_id_seq', 11, true);
            public       postgres    false    203            �
          0    57547 	   indicador 
   TABLE DATA               �   COPY indicador (id, titulo, indicador_id, faixa_id, objetivo_id, usuario_id, calculo, desdobramento, projecao, tipo_calculo, tipo, ordem, status, anos, unidade) FROM stdin;
    public       postgres    false    204   �k      �
          0    57558    indicador_autorizado_visualizar 
   TABLE DATA               P   COPY indicador_autorizado_visualizar (id, usuario_id, indicador_id) FROM stdin;
    public       postgres    false    205   �l      '           0    0 &   indicador_autorizado_visualizar_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('indicador_autorizado_visualizar_id_seq', 234, true);
            public       postgres    false    206            (           0    0    indicador_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('indicador_id_seq', 22, true);
            public       postgres    false    207            �
          0    57565    indicador_meta 
   TABLE DATA               �   COPY indicador_meta (id, indicador_id, janeiro, fevereiro, marco, abril, maio, junho, julho, agosto, setembro, outubro, novembro, dezembro, ano) FROM stdin;
    public       postgres    false    208   Cm      )           0    0    indicador_meta_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('indicador_meta_id_seq', 40, true);
            public       postgres    false    209            �
          0    57573    indicador_realizado 
   TABLE DATA               �   COPY indicador_realizado (id, indicador_id, janeiro, fevereiro, marco, abril, maio, junho, julho, agosto, setembro, outubro, novembro, dezembro, ano) FROM stdin;
    public       postgres    false    210   �m      *           0    0    indicador_realizado_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('indicador_realizado_id_seq', 47, true);
            public       postgres    false    211            �
          0    57581    indicador_responsavel_meta 
   TABLE DATA               K   COPY indicador_responsavel_meta (id, usuario_id, indicador_id) FROM stdin;
    public       postgres    false    212   �n      +           0    0 !   indicador_responsavel_meta_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('indicador_responsavel_meta_id_seq', 208, true);
            public       postgres    false    213            �
          0    57586    indicador_responsavel_realizado 
   TABLE DATA               P   COPY indicador_responsavel_realizado (id, usuario_id, indicador_id) FROM stdin;
    public       postgres    false    214   �n      ,           0    0 &   indicador_responsavel_realizado_id_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('indicador_responsavel_realizado_id_seq', 201, true);
            public       postgres    false    215            �
          0    57591    objetivo 
   TABLE DATA               [   COPY objetivo (id, ano, ordem, titulo, dimensao_id, status, tipo, objetivo_id) FROM stdin;
    public       postgres    false    216   Vo      -           0    0    objetivo_id_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('objetivo_id_seq', 3, true);
            public       postgres    false    217            �
          0    57598    objetivo_projeto 
   TABLE DATA               @   COPY objetivo_projeto (id, projeto_id, objetivo_id) FROM stdin;
    public       postgres    false    218   �o      .           0    0    objetivo_projeto_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('objetivo_projeto_id_seq', 52, true);
            public       postgres    false    219            �
          0    57603    pessoa 
   TABLE DATA               >   COPY pessoa (id, titulo, tipo, observacao, email) FROM stdin;
    public       postgres    false    220   Bp      �
          0    57609    pessoa_comunicacao 
   TABLE DATA               D   COPY pessoa_comunicacao (id, pessoa_id, comunicacao_id) FROM stdin;
    public       postgres    false    221   �u      /           0    0    pessoa_comunicacao_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('pessoa_comunicacao_id_seq', 1, false);
            public       postgres    false    222            0           0    0    pessoa_id_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('pessoa_id_seq', 142, true);
            public       postgres    false    223            �
          0    57616 
   plano_acao 
   TABLE DATA               >   COPY plano_acao (id, objetivo_id, titulo, status) FROM stdin;
    public       postgres    false    224   �u      1           0    0    plano_acao_id_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('plano_acao_id_seq', 2, true);
            public       postgres    false    225            �
          0    57622    plano_acao_projeto 
   TABLE DATA               D   COPY plano_acao_projeto (id, projeto_id, plano_acao_id) FROM stdin;
    public       postgres    false    226   .v      2           0    0    plano_acao_projeto_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('plano_acao_projeto_id_seq', 1, false);
            public       postgres    false    227            �
          0    57627    post 
   TABLE DATA               �   COPY post (id, titulo, mensagem, acao_id, receber_email, status, post_id, created, modified, usuario_id, categoria_id, tarefa_id) FROM stdin;
    public       postgres    false    228   Kv      3           0    0    post_id_seq    SEQUENCE SET     3   SELECT pg_catalog.setval('post_id_seq', 74, true);
            public       postgres    false    229            �
          0    57637    procedimento 
   TABLE DATA               �   COPY procedimento (id, titulo, resultado_esperado, passos, requisito, arquivo, arquivo_dir, usuario_id, certificado, status) FROM stdin;
    public       postgres    false    230   ��      4           0    0    procedimento_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('procedimento_id_seq', 1, true);
            public       postgres    false    231            �
          0    57646    projeto 
   TABLE DATA               �   COPY projeto (id, titulo, data_inicio_previsto, data_fim_previsto, valor, descricao, concluido, data_conclusao, motivacao, resultado, risco, usuario_id, status, custo, moeda) FROM stdin;
    public       postgres    false    232   �      5           0    0    projeto_id_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('projeto_id_seq', 44, true);
            public       postgres    false    233            �
          0    57656    reuniao 
   TABLE DATA               �   COPY reuniao (id, titulo, projeto_id, data, pauta, ata, observacao, convidados_externos, local, status, hora_inicio, hora_fim) FROM stdin;
    public       postgres    false    234   ��      �
          0    57663    reuniao_conhecedor 
   TABLE DATA               A   COPY reuniao_conhecedor (id, reuniao_id, usuario_id) FROM stdin;
    public       postgres    false    235   Ҝ      6           0    0    reuniao_conhecedor_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('reuniao_conhecedor_id_seq', 27, true);
            public       postgres    false    236            �
          0    57668    reuniao_email_externo 
   TABLE DATA               ?   COPY reuniao_email_externo (id, reuniao_id, email) FROM stdin;
    public       postgres    false    237   +�      7           0    0    reuniao_email_externo_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('reuniao_email_externo_id_seq', 14, true);
            public       postgres    false    238            8           0    0    reuniao_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('reuniao_id_seq', 7, true);
            public       postgres    false    239            �
          0    57675    reuniao_participante 
   TABLE DATA               C   COPY reuniao_participante (id, reuniao_id, usuario_id) FROM stdin;
    public       postgres    false    240   ��      9           0    0    reuniao_participante_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('reuniao_participante_id_seq', 28, true);
            public       postgres    false    241            �
          0    57680    setor 
   TABLE DATA               2   COPY setor (id, titulo, status, tipo) FROM stdin;
    public       postgres    false    242   �      :           0    0    setor_id_seq    SEQUENCE SET     4   SELECT pg_catalog.setval('setor_id_seq', 12, true);
            public       postgres    false    243            �
          0    57686    tarefa 
   TABLE DATA               �   COPY tarefa (id, titulo, data_inicio_previsto, data_fim_previsto, concluido, data_conclusao, status, comentario, lembrete, arquivo, arquivo_dir, responsavel_id, supervisor_id, prioridade, reuniao_id, acao_id) FROM stdin;
    public       postgres    false    244   ƞ      ;           0    0    terefa_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('terefa_id_seq', 30, true);
            public       postgres    false    245            �
          0    57696    usuario 
   TABLE DATA               �   COPY usuario (id, login, senha, status, lembrete_senha, foto, enviado, pessoa_id, cargo_id, vinculo_id, cpf, rg, grupo_id, departamento_id, setor_id, chefe, imagem_perfil, diretorio_imagem_perfil, endereco_id) FROM stdin;
    public       postgres    false    246   /�      <           0    0    usuario_id_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('usuario_id_seq', 69, true);
            public       postgres    false    247            �
          0    57706    vinculo 
   TABLE DATA               A   COPY vinculo (id, titulo, status, created, modified) FROM stdin;
    public       postgres    false    248   ��      =           0    0    vinculo_id_seq    SEQUENCE SET     5   SELECT pg_catalog.setval('vinculo_id_seq', 1, true);
            public       postgres    false    249            �	           2606    57756 	   acao_pkey 
   CONSTRAINT     E   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_pkey;
       public         postgres    false    168    168            �	           2606    57758    acao_plano_acao_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY acao_plano_acao
    ADD CONSTRAINT acao_plano_acao_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.acao_plano_acao DROP CONSTRAINT acao_plano_acao_pkey;
       public         postgres    false    170    170            �	           2606    57760 	   acos_pkey 
   CONSTRAINT     E   ALTER TABLE ONLY acos
    ADD CONSTRAINT acos_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.acos DROP CONSTRAINT acos_pkey;
       public         postgres    false    172    172            �	           2606    57762    anomalia_pkey 
   CONSTRAINT     M   ALTER TABLE ONLY anomalia
    ADD CONSTRAINT anomalia_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.anomalia DROP CONSTRAINT anomalia_pkey;
       public         postgres    false    174    174            �	           2606    57764    aros_acos_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY aros_acos
    ADD CONSTRAINT aros_acos_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.aros_acos DROP CONSTRAINT aros_acos_pkey;
       public         postgres    false    177    177            �	           2606    57766 	   aros_pkey 
   CONSTRAINT     E   ALTER TABLE ONLY aros
    ADD CONSTRAINT aros_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.aros DROP CONSTRAINT aros_pkey;
       public         postgres    false    176    176            �	           2606    57768    auditoria_campos_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY auditoria_campos
    ADD CONSTRAINT auditoria_campos_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.auditoria_campos DROP CONSTRAINT auditoria_campos_pkey;
       public         postgres    false    181    181            �	           2606    57770    auditoria_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY auditoria
    ADD CONSTRAINT auditoria_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.auditoria DROP CONSTRAINT auditoria_pkey;
       public         postgres    false    180    180            �	           2606    57772 
   cargo_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY cargo
    ADD CONSTRAINT cargo_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.cargo DROP CONSTRAINT cargo_pkey;
       public         postgres    false    184    184            �	           2606    57774    comentario_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY comentario
    ADD CONSTRAINT comentario_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.comentario DROP CONSTRAINT comentario_pkey;
       public         postgres    false    188    188            �	           2606    57776    comunicacao_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY comunicacao
    ADD CONSTRAINT comunicacao_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.comunicacao DROP CONSTRAINT comunicacao_pkey;
       public         postgres    false    190    190            �	           2606    57778    departamento_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY departamento
    ADD CONSTRAINT departamento_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.departamento DROP CONSTRAINT departamento_pkey;
       public         postgres    false    192    192            �	           2606    57780    dimensao_pkey 
   CONSTRAINT     M   ALTER TABLE ONLY dimensao
    ADD CONSTRAINT dimensao_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.dimensao DROP CONSTRAINT dimensao_pkey;
       public         postgres    false    194    194            �	           2606    57782    empresa_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY empresa
    ADD CONSTRAINT empresa_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.empresa DROP CONSTRAINT empresa_pkey;
       public         postgres    false    196    196            �	           2606    57784    endereco_pkey 
   CONSTRAINT     M   ALTER TABLE ONLY endereco
    ADD CONSTRAINT endereco_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.endereco DROP CONSTRAINT endereco_pkey;
       public         postgres    false    198    198             
           2606    57786 
   faixa_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY faixa
    ADD CONSTRAINT faixa_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.faixa DROP CONSTRAINT faixa_pkey;
       public         postgres    false    200    200            
           2606    57788 
   grupo_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY grupo
    ADD CONSTRAINT grupo_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.grupo DROP CONSTRAINT grupo_pkey;
       public         postgres    false    202    202            �	           2606    57790    id 
   CONSTRAINT     C   ALTER TABLE ONLY categoria
    ADD CONSTRAINT id PRIMARY KEY (id);
 6   ALTER TABLE ONLY public.categoria DROP CONSTRAINT id;
       public         postgres    false    186    186            
           2606    57792 $   indicador_autorizado_visualizar_pkey 
   CONSTRAINT     {   ALTER TABLE ONLY indicador_autorizado_visualizar
    ADD CONSTRAINT indicador_autorizado_visualizar_pkey PRIMARY KEY (id);
 n   ALTER TABLE ONLY public.indicador_autorizado_visualizar DROP CONSTRAINT indicador_autorizado_visualizar_pkey;
       public         postgres    false    205    205            
           2606    57794    indicador_meta_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY indicador_meta
    ADD CONSTRAINT indicador_meta_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.indicador_meta DROP CONSTRAINT indicador_meta_pkey;
       public         postgres    false    208    208            
           2606    57796    indicador_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY indicador
    ADD CONSTRAINT indicador_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.indicador DROP CONSTRAINT indicador_pkey;
       public         postgres    false    204    204            

           2606    57798    indicador_realizado_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY indicador_realizado
    ADD CONSTRAINT indicador_realizado_pkey PRIMARY KEY (id);
 V   ALTER TABLE ONLY public.indicador_realizado DROP CONSTRAINT indicador_realizado_pkey;
       public         postgres    false    210    210            
           2606    57800    indicador_responsavel_meta_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY indicador_responsavel_meta
    ADD CONSTRAINT indicador_responsavel_meta_pkey PRIMARY KEY (id);
 d   ALTER TABLE ONLY public.indicador_responsavel_meta DROP CONSTRAINT indicador_responsavel_meta_pkey;
       public         postgres    false    212    212            
           2606    57802 $   indicador_responsavel_realizado_pkey 
   CONSTRAINT     {   ALTER TABLE ONLY indicador_responsavel_realizado
    ADD CONSTRAINT indicador_responsavel_realizado_pkey PRIMARY KEY (id);
 n   ALTER TABLE ONLY public.indicador_responsavel_realizado DROP CONSTRAINT indicador_responsavel_realizado_pkey;
       public         postgres    false    214    214            
           2606    57804    objetivo_pkey 
   CONSTRAINT     M   ALTER TABLE ONLY objetivo
    ADD CONSTRAINT objetivo_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.objetivo DROP CONSTRAINT objetivo_pkey;
       public         postgres    false    216    216            
           2606    57806    pessoa_comunicacao_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY pessoa_comunicacao
    ADD CONSTRAINT pessoa_comunicacao_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.pessoa_comunicacao DROP CONSTRAINT pessoa_comunicacao_pkey;
       public         postgres    false    221    221            
           2606    57808    pessoa_pkey 
   CONSTRAINT     I   ALTER TABLE ONLY pessoa
    ADD CONSTRAINT pessoa_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.pessoa DROP CONSTRAINT pessoa_pkey;
       public         postgres    false    220    220            
           2606    57810    plano_acao_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY plano_acao
    ADD CONSTRAINT plano_acao_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.plano_acao DROP CONSTRAINT plano_acao_pkey;
       public         postgres    false    224    224            
           2606    57812    plano_acao_projeto_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY plano_acao_projeto
    ADD CONSTRAINT plano_acao_projeto_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.plano_acao_projeto DROP CONSTRAINT plano_acao_projeto_pkey;
       public         postgres    false    226    226            
           2606    57814 	   post_pkey 
   CONSTRAINT     E   ALTER TABLE ONLY post
    ADD CONSTRAINT post_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.post DROP CONSTRAINT post_pkey;
       public         postgres    false    228    228            
           2606    57816    procedimento_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY procedimento
    ADD CONSTRAINT procedimento_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.procedimento DROP CONSTRAINT procedimento_pkey;
       public         postgres    false    230    230            
           2606    57818    projeto_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY projeto
    ADD CONSTRAINT projeto_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.projeto DROP CONSTRAINT projeto_pkey;
       public         postgres    false    232    232            #
           2606    57820    reuniao_conhecedor_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY reuniao_conhecedor
    ADD CONSTRAINT reuniao_conhecedor_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.reuniao_conhecedor DROP CONSTRAINT reuniao_conhecedor_pkey;
       public         postgres    false    235    235            %
           2606    57822    reuniao_email_externo_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY reuniao_email_externo
    ADD CONSTRAINT reuniao_email_externo_pkey PRIMARY KEY (id);
 Z   ALTER TABLE ONLY public.reuniao_email_externo DROP CONSTRAINT reuniao_email_externo_pkey;
       public         postgres    false    237    237            '
           2606    57824    reuniao_participante_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY reuniao_participante
    ADD CONSTRAINT reuniao_participante_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.reuniao_participante DROP CONSTRAINT reuniao_participante_pkey;
       public         postgres    false    240    240            !
           2606    57826    reuniao_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY reuniao
    ADD CONSTRAINT reuniao_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.reuniao DROP CONSTRAINT reuniao_pkey;
       public         postgres    false    234    234            )
           2606    57828 
   setor_pkey 
   CONSTRAINT     G   ALTER TABLE ONLY setor
    ADD CONSTRAINT setor_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.setor DROP CONSTRAINT setor_pkey;
       public         postgres    false    242    242            +
           2606    57830    terefa_pkey 
   CONSTRAINT     I   ALTER TABLE ONLY tarefa
    ADD CONSTRAINT terefa_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.tarefa DROP CONSTRAINT terefa_pkey;
       public         postgres    false    244    244            -
           2606    57832    usuario_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
       public         postgres    false    246    246            /
           2606    57834    vinculo_pkey 
   CONSTRAINT     K   ALTER TABLE ONLY vinculo
    ADD CONSTRAINT vinculo_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.vinculo DROP CONSTRAINT vinculo_pkey;
       public         postgres    false    248    248            �	           1259    57835    aro_aco_key    INDEX     K   CREATE UNIQUE INDEX aro_aco_key ON aros_acos USING btree (aro_id, aco_id);
    DROP INDEX public.aro_aco_key;
       public         postgres    false    177    177            
           1259    57836    fki_tarefa_pfkey_id    INDEX     B   CREATE INDEX fki_tarefa_pfkey_id ON post USING btree (tarefa_id);
 '   DROP INDEX public.fki_tarefa_pfkey_id;
       public         postgres    false    228            0
           2606    57837    acao_acao_id_fkey    FK CONSTRAINT     f   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_acao_id_fkey FOREIGN KEY (acao_id) REFERENCES acao(id);
 @   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_acao_id_fkey;
       public       postgres    false    2527    168    168            1
           2606    57842    acao_anomalia_id_fkey    FK CONSTRAINT     r   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_anomalia_id_fkey FOREIGN KEY (anomalia_id) REFERENCES anomalia(id);
 D   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_anomalia_id_fkey;
       public       postgres    false    2533    174    168            2
           2606    57847    acao_objetivo_id_fkey    FK CONSTRAINT     r   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_objetivo_id_fkey FOREIGN KEY (objetivo_id) REFERENCES objetivo(id);
 D   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_objetivo_id_fkey;
       public       postgres    false    216    2576    168            6
           2606    57852    acao_plano_acao_acao_id_fkey    FK CONSTRAINT     |   ALTER TABLE ONLY acao_plano_acao
    ADD CONSTRAINT acao_plano_acao_acao_id_fkey FOREIGN KEY (acao_id) REFERENCES acao(id);
 V   ALTER TABLE ONLY public.acao_plano_acao DROP CONSTRAINT acao_plano_acao_acao_id_fkey;
       public       postgres    false    170    2527    168            7
           2606    57857 "   acao_plano_acao_plano_acao_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY acao_plano_acao
    ADD CONSTRAINT acao_plano_acao_plano_acao_id_fkey FOREIGN KEY (plano_acao_id) REFERENCES plano_acao(id);
 \   ALTER TABLE ONLY public.acao_plano_acao DROP CONSTRAINT acao_plano_acao_plano_acao_id_fkey;
       public       postgres    false    2582    170    224            3
           2606    57862    acao_projeto_id_fkey    FK CONSTRAINT     z   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_projeto_id_fkey FOREIGN KEY (projeto_id) REFERENCES projeto(id) DEFERRABLE;
 C   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_projeto_id_fkey;
       public       postgres    false    168    2591    232            4
           2606    57867    acao_responsavel_id_fkey    FK CONSTRAINT     w   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_responsavel_id_fkey FOREIGN KEY (responsavel_id) REFERENCES usuario(id);
 G   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_responsavel_id_fkey;
       public       postgres    false    246    2605    168            5
           2606    57872    acao_supervisor_id_fkey    FK CONSTRAINT     u   ALTER TABLE ONLY acao
    ADD CONSTRAINT acao_supervisor_id_fkey FOREIGN KEY (supervisor_id) REFERENCES usuario(id);
 F   ALTER TABLE ONLY public.acao DROP CONSTRAINT acao_supervisor_id_fkey;
       public       postgres    false    2605    168    246            8
           2606    57877    anomalia_indicador_id_fkey    FK CONSTRAINT     }   ALTER TABLE ONLY anomalia
    ADD CONSTRAINT anomalia_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 M   ALTER TABLE ONLY public.anomalia DROP CONSTRAINT anomalia_indicador_id_fkey;
       public       postgres    false    2564    174    204            :
           2606    57882 "   auditoria_campos_auditoria_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY auditoria_campos
    ADD CONSTRAINT auditoria_campos_auditoria_id_fkey FOREIGN KEY (auditoria_id) REFERENCES auditoria(id);
 ]   ALTER TABLE ONLY public.auditoria_campos DROP CONSTRAINT auditoria_campos_auditoria_id_fkey;
       public       postgres    false    180    181    2540            9
           2606    57887    auditoria_usuario_id_fkey    FK CONSTRAINT     y   ALTER TABLE ONLY auditoria
    ADD CONSTRAINT auditoria_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 M   ALTER TABLE ONLY public.auditoria DROP CONSTRAINT auditoria_usuario_id_fkey;
       public       postgres    false    246    2605    180            ;
           2606    57892    comentario_acao_id_fkey    FK CONSTRAINT     r   ALTER TABLE ONLY comentario
    ADD CONSTRAINT comentario_acao_id_fkey FOREIGN KEY (acao_id) REFERENCES acao(id);
 L   ALTER TABLE ONLY public.comentario DROP CONSTRAINT comentario_acao_id_fkey;
       public       postgres    false    188    168    2527            <
           2606    57897    comentario_usuario_id_fkey    FK CONSTRAINT     {   ALTER TABLE ONLY comentario
    ADD CONSTRAINT comentario_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 O   ALTER TABLE ONLY public.comentario DROP CONSTRAINT comentario_usuario_id_fkey;
       public       postgres    false    188    246    2605            =
           2606    57902    dimensao_empresa_id_fkey    FK CONSTRAINT     w   ALTER TABLE ONLY dimensao
    ADD CONSTRAINT dimensao_empresa_id_fkey FOREIGN KEY (empresa_id) REFERENCES empresa(id);
 K   ALTER TABLE ONLY public.dimensao DROP CONSTRAINT dimensao_empresa_id_fkey;
       public       postgres    false    196    194    2556            >
           2606    57907    empresa_empresa_id_fkey    FK CONSTRAINT     u   ALTER TABLE ONLY empresa
    ADD CONSTRAINT empresa_empresa_id_fkey FOREIGN KEY (empresa_id) REFERENCES empresa(id);
 I   ALTER TABLE ONLY public.empresa DROP CONSTRAINT empresa_empresa_id_fkey;
       public       postgres    false    196    2556    196            ?
           2606    57912    empresa_pessoa_id_fkey    FK CONSTRAINT     r   ALTER TABLE ONLY empresa
    ADD CONSTRAINT empresa_pessoa_id_fkey FOREIGN KEY (pessoa_id) REFERENCES pessoa(id);
 H   ALTER TABLE ONLY public.empresa DROP CONSTRAINT empresa_pessoa_id_fkey;
       public       postgres    false    220    196    2578            D
           2606    57917 1   indicador_autorizado_visualizar_indicador_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_autorizado_visualizar
    ADD CONSTRAINT indicador_autorizado_visualizar_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 {   ALTER TABLE ONLY public.indicador_autorizado_visualizar DROP CONSTRAINT indicador_autorizado_visualizar_indicador_id_fkey;
       public       postgres    false    205    2564    204            E
           2606    57922 /   indicador_autorizado_visualizar_usuario_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_autorizado_visualizar
    ADD CONSTRAINT indicador_autorizado_visualizar_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 y   ALTER TABLE ONLY public.indicador_autorizado_visualizar DROP CONSTRAINT indicador_autorizado_visualizar_usuario_id_fkey;
       public       postgres    false    246    205    2605            @
           2606    57927    indicador_faixa_id_fkey    FK CONSTRAINT     s   ALTER TABLE ONLY indicador
    ADD CONSTRAINT indicador_faixa_id_fkey FOREIGN KEY (faixa_id) REFERENCES faixa(id);
 K   ALTER TABLE ONLY public.indicador DROP CONSTRAINT indicador_faixa_id_fkey;
       public       postgres    false    200    2560    204            A
           2606    57932    indicador_indicador_id_fkey    FK CONSTRAINT        ALTER TABLE ONLY indicador
    ADD CONSTRAINT indicador_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 O   ALTER TABLE ONLY public.indicador DROP CONSTRAINT indicador_indicador_id_fkey;
       public       postgres    false    2564    204    204            F
           2606    57937     indicador_meta_indicador_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_meta
    ADD CONSTRAINT indicador_meta_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 Y   ALTER TABLE ONLY public.indicador_meta DROP CONSTRAINT indicador_meta_indicador_id_fkey;
       public       postgres    false    204    2564    208            B
           2606    57942    indicador_objetivo_id_fkey    FK CONSTRAINT     |   ALTER TABLE ONLY indicador
    ADD CONSTRAINT indicador_objetivo_id_fkey FOREIGN KEY (objetivo_id) REFERENCES objetivo(id);
 N   ALTER TABLE ONLY public.indicador DROP CONSTRAINT indicador_objetivo_id_fkey;
       public       postgres    false    216    204    2576            G
           2606    57947 %   indicador_realizado_indicador_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_realizado
    ADD CONSTRAINT indicador_realizado_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 c   ALTER TABLE ONLY public.indicador_realizado DROP CONSTRAINT indicador_realizado_indicador_id_fkey;
       public       postgres    false    204    210    2564            H
           2606    57952 ,   indicador_responsavel_meta_indicador_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_responsavel_meta
    ADD CONSTRAINT indicador_responsavel_meta_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 q   ALTER TABLE ONLY public.indicador_responsavel_meta DROP CONSTRAINT indicador_responsavel_meta_indicador_id_fkey;
       public       postgres    false    212    2564    204            I
           2606    57957 *   indicador_responsavel_meta_usuario_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_responsavel_meta
    ADD CONSTRAINT indicador_responsavel_meta_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 o   ALTER TABLE ONLY public.indicador_responsavel_meta DROP CONSTRAINT indicador_responsavel_meta_usuario_id_fkey;
       public       postgres    false    212    2605    246            J
           2606    57962 1   indicador_responsavel_realizado_indicador_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_responsavel_realizado
    ADD CONSTRAINT indicador_responsavel_realizado_indicador_id_fkey FOREIGN KEY (indicador_id) REFERENCES indicador(id);
 {   ALTER TABLE ONLY public.indicador_responsavel_realizado DROP CONSTRAINT indicador_responsavel_realizado_indicador_id_fkey;
       public       postgres    false    2564    214    204            K
           2606    57967 /   indicador_responsavel_realizado_usuario_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY indicador_responsavel_realizado
    ADD CONSTRAINT indicador_responsavel_realizado_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 y   ALTER TABLE ONLY public.indicador_responsavel_realizado DROP CONSTRAINT indicador_responsavel_realizado_usuario_id_fkey;
       public       postgres    false    246    2605    214            C
           2606    57972    indicador_usuario_id_fkey    FK CONSTRAINT     y   ALTER TABLE ONLY indicador
    ADD CONSTRAINT indicador_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 M   ALTER TABLE ONLY public.indicador DROP CONSTRAINT indicador_usuario_id_fkey;
       public       postgres    false    2605    246    204            L
           2606    57977    objetivo_dimensao_id_fkey    FK CONSTRAINT     z   ALTER TABLE ONLY objetivo
    ADD CONSTRAINT objetivo_dimensao_id_fkey FOREIGN KEY (dimensao_id) REFERENCES dimensao(id);
 L   ALTER TABLE ONLY public.objetivo DROP CONSTRAINT objetivo_dimensao_id_fkey;
       public       postgres    false    194    2554    216            M
           2606    57982    objetivo_objetivo_id_fkey    FK CONSTRAINT     z   ALTER TABLE ONLY objetivo
    ADD CONSTRAINT objetivo_objetivo_id_fkey FOREIGN KEY (objetivo_id) REFERENCES objetivo(id);
 L   ALTER TABLE ONLY public.objetivo DROP CONSTRAINT objetivo_objetivo_id_fkey;
       public       postgres    false    216    2576    216            N
           2606    57987 &   pessoa_comunicacao_comunicacao_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY pessoa_comunicacao
    ADD CONSTRAINT pessoa_comunicacao_comunicacao_id_fkey FOREIGN KEY (comunicacao_id) REFERENCES comunicacao(id);
 c   ALTER TABLE ONLY public.pessoa_comunicacao DROP CONSTRAINT pessoa_comunicacao_comunicacao_id_fkey;
       public       postgres    false    221    2550    190            O
           2606    57992 !   pessoa_comunicacao_pessoa_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY pessoa_comunicacao
    ADD CONSTRAINT pessoa_comunicacao_pessoa_id_fkey FOREIGN KEY (pessoa_id) REFERENCES pessoa(id);
 ^   ALTER TABLE ONLY public.pessoa_comunicacao DROP CONSTRAINT pessoa_comunicacao_pessoa_id_fkey;
       public       postgres    false    220    221    2578            P
           2606    57997    plano_acao_objetivo_id_fkey    FK CONSTRAINT     ~   ALTER TABLE ONLY plano_acao
    ADD CONSTRAINT plano_acao_objetivo_id_fkey FOREIGN KEY (objetivo_id) REFERENCES objetivo(id);
 P   ALTER TABLE ONLY public.plano_acao DROP CONSTRAINT plano_acao_objetivo_id_fkey;
       public       postgres    false    2576    216    224            Q
           2606    58002 %   plano_acao_projeto_plano_acao_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY plano_acao_projeto
    ADD CONSTRAINT plano_acao_projeto_plano_acao_id_fkey FOREIGN KEY (plano_acao_id) REFERENCES plano_acao(id);
 b   ALTER TABLE ONLY public.plano_acao_projeto DROP CONSTRAINT plano_acao_projeto_plano_acao_id_fkey;
       public       postgres    false    226    2582    224            R
           2606    58007 "   plano_acao_projeto_projeto_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY plano_acao_projeto
    ADD CONSTRAINT plano_acao_projeto_projeto_id_fkey FOREIGN KEY (projeto_id) REFERENCES projeto(id);
 _   ALTER TABLE ONLY public.plano_acao_projeto DROP CONSTRAINT plano_acao_projeto_projeto_id_fkey;
       public       postgres    false    2591    232    226            S
           2606    58012    post_acao_id_fkey    FK CONSTRAINT     f   ALTER TABLE ONLY post
    ADD CONSTRAINT post_acao_id_fkey FOREIGN KEY (acao_id) REFERENCES acao(id);
 @   ALTER TABLE ONLY public.post DROP CONSTRAINT post_acao_id_fkey;
       public       postgres    false    2527    228    168            T
           2606    58017    post_categoria_id_fkey    FK CONSTRAINT     u   ALTER TABLE ONLY post
    ADD CONSTRAINT post_categoria_id_fkey FOREIGN KEY (categoria_id) REFERENCES categoria(id);
 E   ALTER TABLE ONLY public.post DROP CONSTRAINT post_categoria_id_fkey;
       public       postgres    false    2546    186    228            U
           2606    58022    post_post_id_fkey    FK CONSTRAINT     f   ALTER TABLE ONLY post
    ADD CONSTRAINT post_post_id_fkey FOREIGN KEY (post_id) REFERENCES post(id);
 @   ALTER TABLE ONLY public.post DROP CONSTRAINT post_post_id_fkey;
       public       postgres    false    228    2587    228            V
           2606    58027    post_usuario_id_fkey    FK CONSTRAINT     o   ALTER TABLE ONLY post
    ADD CONSTRAINT post_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 C   ALTER TABLE ONLY public.post DROP CONSTRAINT post_usuario_id_fkey;
       public       postgres    false    246    228    2605            X
           2606    58032    procedimento_usuario_id_fkey    FK CONSTRAINT        ALTER TABLE ONLY procedimento
    ADD CONSTRAINT procedimento_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 S   ALTER TABLE ONLY public.procedimento DROP CONSTRAINT procedimento_usuario_id_fkey;
       public       postgres    false    2605    230    246            Y
           2606    58037    projeto_usuario_id_fkey    FK CONSTRAINT     u   ALTER TABLE ONLY projeto
    ADD CONSTRAINT projeto_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 I   ALTER TABLE ONLY public.projeto DROP CONSTRAINT projeto_usuario_id_fkey;
       public       postgres    false    246    2605    232            [
           2606    58042 "   reuniao_conhecedor_reuniao_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY reuniao_conhecedor
    ADD CONSTRAINT reuniao_conhecedor_reuniao_id_fkey FOREIGN KEY (reuniao_id) REFERENCES reuniao(id);
 _   ALTER TABLE ONLY public.reuniao_conhecedor DROP CONSTRAINT reuniao_conhecedor_reuniao_id_fkey;
       public       postgres    false    235    2593    234            \
           2606    58047 "   reuniao_conhecedor_usuario_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY reuniao_conhecedor
    ADD CONSTRAINT reuniao_conhecedor_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 _   ALTER TABLE ONLY public.reuniao_conhecedor DROP CONSTRAINT reuniao_conhecedor_usuario_id_fkey;
       public       postgres    false    246    2605    235            ]
           2606    58052 %   reuniao_email_externo_reuniao_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY reuniao_email_externo
    ADD CONSTRAINT reuniao_email_externo_reuniao_id_fkey FOREIGN KEY (reuniao_id) REFERENCES reuniao(id);
 e   ALTER TABLE ONLY public.reuniao_email_externo DROP CONSTRAINT reuniao_email_externo_reuniao_id_fkey;
       public       postgres    false    2593    234    237            ^
           2606    58057 $   reuniao_participante_reuniao_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY reuniao_participante
    ADD CONSTRAINT reuniao_participante_reuniao_id_fkey FOREIGN KEY (reuniao_id) REFERENCES reuniao(id);
 c   ALTER TABLE ONLY public.reuniao_participante DROP CONSTRAINT reuniao_participante_reuniao_id_fkey;
       public       postgres    false    234    240    2593            _
           2606    58062 $   reuniao_participante_usuario_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY reuniao_participante
    ADD CONSTRAINT reuniao_participante_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES usuario(id);
 c   ALTER TABLE ONLY public.reuniao_participante DROP CONSTRAINT reuniao_participante_usuario_id_fkey;
       public       postgres    false    2605    246    240            Z
           2606    58067    reuniao_projeto_id_fkey    FK CONSTRAINT     u   ALTER TABLE ONLY reuniao
    ADD CONSTRAINT reuniao_projeto_id_fkey FOREIGN KEY (projeto_id) REFERENCES projeto(id);
 I   ALTER TABLE ONLY public.reuniao DROP CONSTRAINT reuniao_projeto_id_fkey;
       public       postgres    false    234    2591    232            `
           2606    58072    tarefa_acao_id_fkey    FK CONSTRAINT     j   ALTER TABLE ONLY tarefa
    ADD CONSTRAINT tarefa_acao_id_fkey FOREIGN KEY (acao_id) REFERENCES acao(id);
 D   ALTER TABLE ONLY public.tarefa DROP CONSTRAINT tarefa_acao_id_fkey;
       public       postgres    false    168    2527    244            W
           2606    58077    tarefa_pfkey_id    FK CONSTRAINT     h   ALTER TABLE ONLY post
    ADD CONSTRAINT tarefa_pfkey_id FOREIGN KEY (tarefa_id) REFERENCES tarefa(id);
 >   ALTER TABLE ONLY public.post DROP CONSTRAINT tarefa_pfkey_id;
       public       postgres    false    244    2603    228            a
           2606    58082    tarefa_reuniao_id_fkey    FK CONSTRAINT     s   ALTER TABLE ONLY tarefa
    ADD CONSTRAINT tarefa_reuniao_id_fkey FOREIGN KEY (reuniao_id) REFERENCES reuniao(id);
 G   ALTER TABLE ONLY public.tarefa DROP CONSTRAINT tarefa_reuniao_id_fkey;
       public       postgres    false    234    244    2593            b
           2606    58087    terefa_responsavel_id_fkey    FK CONSTRAINT     {   ALTER TABLE ONLY tarefa
    ADD CONSTRAINT terefa_responsavel_id_fkey FOREIGN KEY (responsavel_id) REFERENCES usuario(id);
 K   ALTER TABLE ONLY public.tarefa DROP CONSTRAINT terefa_responsavel_id_fkey;
       public       postgres    false    246    244    2605            c
           2606    58092    terefa_supervisor_id_fkey    FK CONSTRAINT     y   ALTER TABLE ONLY tarefa
    ADD CONSTRAINT terefa_supervisor_id_fkey FOREIGN KEY (supervisor_id) REFERENCES usuario(id);
 J   ALTER TABLE ONLY public.tarefa DROP CONSTRAINT terefa_supervisor_id_fkey;
       public       postgres    false    244    2605    246            d
           2606    58097    usuario_cargo_id_fkey    FK CONSTRAINT     o   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_cargo_id_fkey FOREIGN KEY (cargo_id) REFERENCES cargo(id);
 G   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_cargo_id_fkey;
       public       postgres    false    246    2544    184            e
           2606    58102    usuario_departamento_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_departamento_id_fkey FOREIGN KEY (departamento_id) REFERENCES departamento(id);
 N   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_departamento_id_fkey;
       public       postgres    false    246    2552    192            f
           2606    58107    usuario_endereco_id_fkey    FK CONSTRAINT     x   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_endereco_id_fkey FOREIGN KEY (endereco_id) REFERENCES endereco(id);
 J   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_endereco_id_fkey;
       public       postgres    false    246    2558    198            g
           2606    58112    usuario_grupo_id_fkey    FK CONSTRAINT     o   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_grupo_id_fkey FOREIGN KEY (grupo_id) REFERENCES grupo(id);
 G   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_grupo_id_fkey;
       public       postgres    false    246    2562    202            h
           2606    58117    usuario_pessoa_id_fkey    FK CONSTRAINT     r   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pessoa_id_fkey FOREIGN KEY (pessoa_id) REFERENCES pessoa(id);
 H   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pessoa_id_fkey;
       public       postgres    false    246    2578    220            i
           2606    58122    usuario_setor_id_fkey    FK CONSTRAINT     o   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_setor_id_fkey FOREIGN KEY (setor_id) REFERENCES setor(id);
 G   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_setor_id_fkey;
       public       postgres    false    242    2601    246            j
           2606    58127    usuario_vinculo_id_fkey    FK CONSTRAINT     u   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_vinculo_id_fkey FOREIGN KEY (vinculo_id) REFERENCES vinculo(id);
 I   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_vinculo_id_fkey;
       public       postgres    false    246    2607    248            �           826    58133     DEFAULT PRIVILEGES FOR SEQUENCES    DEFAULT ACL     B  ALTER DEFAULT PRIVILEGES FOR ROLE postgres REVOKE ALL ON SEQUENCES  FROM PUBLIC;
ALTER DEFAULT PRIVILEGES FOR ROLE postgres REVOKE ALL ON SEQUENCES  FROM postgres;
ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON SEQUENCES  TO postgres;
ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON SEQUENCES  TO PUBLIC;
                  postgres    false            �           826    58135    DEFAULT PRIVILEGES FOR TABLES    DEFAULT ACL     6  ALTER DEFAULT PRIVILEGES FOR ROLE postgres REVOKE ALL ON TABLES  FROM PUBLIC;
ALTER DEFAULT PRIVILEGES FOR ROLE postgres REVOKE ALL ON TABLES  FROM postgres;
ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON TABLES  TO postgres;
ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON TABLES  TO PUBLIC;
                  postgres    false            k
   *  x��Xˎ�6]K_�M��Q)i9�8��fj4���ad���,��d4��������n����ROZ�2(0S�ѹ�sϽR8?����⿕B�Bj�����2�Ο�J��p��������*��缿s�~����'H?rn�/�O7��h�/�ϟYc�<�;bFZ��x{�-8N�"���Ez���͑���Fm/lԨB�*v�Qݨ�?0���z�����)���p�r�Yg ��+���L�Iv�ض���Bd�SU������T�~�t�bC �R�,O�P�Gk+MW~��(si
]z���
��=��9F+?YL\Jm`b�e�ˬ`�C�<ǋ��K#� �������&�ZK=��A}2�4@��A����f��(�\�K��-SU��5^�{����7@6U�� �؞&���bύ� �L�.��<������1'��Ad�Bpߍ�x4�ˤ�L�l�B���k�J�F�).�
��<%���)��B�ثN��*)?�}&hs�k�\�w�F�����z���ʠ9҅pč1�A
����]d���\�<�}��ь2�J�
�t�`6�jF���8�)�aM�Xc0&Ǡ?S���$%�<��!�!��x����G&4GP���L˪���$����3����#|�5Cm�u�P*�4+���ӣ�43�7CV������Ə������Bo�����
qb��,$hT�]�H*�����$�"�)��R���?0���'���w�nwS�o؆�&��nV�TΔ�������'��^�f��$2��69��B�=�W��ְ :4�l��DYM��p�j�+39��XE0�����Q���S�ڦB�*OQ=��-vm�  ����LK��x�Kt�K��l�0uU�H�wl�hs��vl�74�.H�U$�Z��h��d�?�c��={��	��i>X�����2q����Ӳ���Z��=Q���b��*�#YKَ�\"Y�L�H���8��6�*�Л��WzC�T����:��1�1T��J������j`td�����8����P�� G����<�n���"�R�Ĭ+Թ�V�M�O<�����V��z'R��O�$�Ŝ�(���ѯ��wh/p�M=͉�xIc�2�
�T�*m���ܙgd(wͼ����ƫ$���'�à`eY4M�2]�u�� �n�W�	�F)7��$����uZn�`�A�sy2��)o�$��x:�c��k;D�G	k���4����qz�#i_�K�5�(�sǇaZ�.����v}g�Z�ܮ���ݓפ���38w��>���o&��#�hA�|q���bg�@B��Z���z����#3�I���h��.
p�6�[�6�CP"	��;�z��H���\��\�\3���<��"���7������?^=��&��n��w[�۠xϺ�z�Z?9A@�	��P�=<#ي�-�t�G�6�U&�Y��Ԗ�C @;J ۨ�2����{wc5ak����P��FM�}��ζ��䎉����J`��LI���"�J��]�A~�����	�$      m
      x������ � �      o
   e  x�mWMo�F=L1�|m�衻����Q��v����1�4#�@|�3$���	�|��o�������0;�<9#�q8<���O~=k����8�|�D��:tO�n�>�L�Է��9�)�^��p����\}�y>:=�YL?v���Q������A_0,�|����H�b�&	��s�/�գ�"��\��n1�'^���K,�iv6��yM���uꏝAT�)��?O���0P
�U�H�klb�-��d	.��i��?�.d�;WS��� �BZ?�?��}��T=�[�5C�&n���2�ƥ�yr&y�\�ߏ���h+�l����h�э�^�`��I��V���	��۾�}ޒ��֦��I��7���x!���1``���� �i���R�u�<���5����~�$�3�y�'��i}����N�K �	=��Ks��PFc
)���FS��R5�: �t}M��Ȃ���:'�	��_��y?MH$��c�E(���i�x?M��pZ!�`m9r0Sjt��!!F��P���3�
�X��5S,�X�]�q�CϤ�p�"������doJ ��9��L���߳v��e=�<�O���?����)єD�87<�l��S��RE�\ ��i�g�s�m��ǘ=�����"_�)�j]Je�h�X����gxM���B
����5�)�I��>:��Cs���W�&P�:c�1!���:ҕp��a�`���^0V��]V�1��6��nx���%��v|��>Q���f�&a_H��vYK�R��%����4�%L���Cr����6�B�&W�~9���iTOD�Ji�a{����IYe�f`8�"��&��-eW�M�Qi��j]�ʞ�t�oZ&�.��}��g�,Igfcɨt.�N,��RA=
vp�\y��$��8	a���S�Fq����D
� �ĕ�M���h��g����Cx� X��b�k��=����yءW���n����|����Rv=�/H�n�IZ��Cė���`P,�|7:��'�p�7���ǔ�����al%T�\Í�쩄ƴ	=�`��\-�ZR����D$(���.�t�4�
����'��rj��éX��H~���N����,�%X��SIf�P�@9
T���[j���Kc_5&V>[U��F9B�	C��Ƒ��0�8�64�1�>�+��b����&U1�!�o�LT�@8�j@�"3Q%"*�Kk\bV��TOW��uza?O�K�]��V�!�*'܌�q�-wD�8�%zyl>X���},��l��¸��U�#{�j�q<�4.Tī����W%����9x�΀Rj}:�d�!Ƶ�� ������i��~a����"�9#W       q
     x��PKN�0]�O�y�n�����Q�Hi��1�(,�\�����@c����=k^N�U�,���Ƙ+�:G��`	�� ���<u�]E��_�|?��⨿�f��2ǌ�h�3B�37��~���'��}�L��T�i�p=­�(�s:����5�X��bJ�;w~1>3b�~��f�B��D}G@�u�2tHC*Wō�%VX�(ã喎�������P
��oI-�	�M�� u�u�����g��XK�Ճ�u�E���!��v�<x�B� ���      s
   �  x�U�=n\1�k�0��+��ҹs�2���QAVl���qHQ����ϯ�ϧ��,���?_??}��w
6��f��$���)��A"��[�Rp�1�o���#����GY���{���7�*1'����&Yc�bV'ř��ŬI:��3hu�56+��G(є�3J
��Ram
2@IB���W�.쭚�j��GS��t��l�dy3M�l�Y�  �F0��E�yu�q�j��D,���S�D=��� ���l���sr4%J�I��*����h�3�����Y�J�8�Y�Ess4�(j��;Q����m� � %�oY�M�	�[��5G�]�*m�QԠ���%p��嬆���<oe��*M;�c w��j��hH>&�|���/�=h�5fS*�Z��~VSʹ����V��T.�=Y�Uѹ*h���
�YEN�`��C���r�$�c���_�m;�q`w�Vk�V��ܶ	ȳՔ���7f��S=�      t
     x�e�[v�0C�={i�I=(��_G-��@�I>2���)���.�ˮ_�ߏ��hy�(��������?[j�R��%��[m���JW%�2TY[���VB���j�A�\����&���p�oj�i^}8ܯ�(4��*�L�S���R���,�60-K�P#S�40��K�����������?������n���;dOt�7���Ai�;�r��ʕ�#(�8;Br����QV�,���TS�A��(�a]���� �v� �v� �&2���� ������ꪤ���8��B�LPt52A�����g���ZLPL52ٰjd�a# ��<9�UA1�<���	P��v�-���[���A
�E�"�uqxE�x�����ݴ@�o�"4����(B��@J�x�Մ(�R,P,�X�XJ��X�p�`)A� �)��H�HP�R$(R)r�h�B$w׭I��C�͛K%r�J�F�-oޥz�����PmP����7d��OZ;� $K5� ��DrzHW�Ei*� ]%D)8��uٷ*�ߪ�|/�㝼0nM��ݚg��fMvk:�Lo���*���U�p������[]�<~|�<^���7.h＠7Hr`0�B��]�yp\0�ypf���Ln�?�?��_Z^u�      w
   �  x���ˮ$9��YO�/�(��j�@Bl�cs4ӠFC7:�H<>��ʩ�,;�4��/}����Uu��wo_���?��뗷�-�-�A>��1�1�c�k�$�j���?��lw��_.��?����I����X�����&z��}1���u˭�>��6���߼��c|
)�C�­��w�?�{�]�n��5�rߋ�m�~�{|����`��þc����ۭ��^,�iY����=��p� q�Z�d������m����~��*	����!}�k�i�[������~���k8��5;��)`Y�c�N�}`n�l�KܤN�_������_��,�g�3�k�b|1�+��x3���߷��Nl��<	�Q���=Í�V�/@|_�������$��r�U馐u.T��6���l�Ъ�l	�_9ӳ)�˼��'��v�}(d-������m��������p�M8.G�ݥ�i�O�> �c�Wf��� c\b+M*�
G5��[a��=n�!�x�p�!�TyۅX���.��0"�^�
E��Gq�e����4H\@��p��(�W]���-BadAZD!Y���-B� -*,��,H+�Q�tAZp7�������׈�+-�x-諺���W�����TW��++��ANNL��CH���ڢe�{����d�@^�܈��f�Wyp6�Ǒ~v����J�υ��7,/y�!�O�|��V�����O_>��B){AXQ�+�����"�|�4��L��ǁ/���?9R4Z��+ɻ�4�Y��1τX��V�ХP�i�⢙9���}7��|�eN8ގa+�9�<��8��b�)�ryx�{ͤ�Ami_��ac���K�{�K��.]�o���J\��W�����Wå��� ;7�W��g� �/^3��'�65A�>)���� ���3ڨ��N����T�{m>lF�r�W`����q���̕�����\�	�-ҕVu�6��Y=��l���jm-�T�΍����6�\����z���m/F�_��П�O����	��%�y���8��peN�hGz���׵��8�bR�{����R��'�8��=XX�aFӽ�k��=]�/_��Z�+���?mߑ|�[�wwi��Ɔ�J�K�s�h*���Q����%Zf��e��	�1��j��E�o���g�)G�� ���j�ٙ]>X�\�~��\63���0�e���ɮ
�[�D5'�2	���@��U��O�^-������=N�R����`�hyf�]��j���r�V��ۋ����=�-���qӭc�]HV��QDWv,��c��0��m7r�����s�t;Ʃ�0�<c�����yrP�8���I��T����}�cƏ{���]D>Q���v#�e�>�<l�]�I�0Q��`EX9���q����*����7-+l|����|����ȱ�p��R`S2�_��EÅ�xc^�%���Z̈�� 
��j���BsJ�C�;Y��6��.��ѡ�<Y����[�	�;�M`L:�2zA<��*TG_�����(��A�ቌ9��j�B��X`�s0idp�LW�8�]^��W]�oIV�I����jE��X6B�V��x2@���Ss6hy*>n��K�Hu	gsخ�4��X���%^-e���>�˃�؂�!Ḵx��3��/NG����#D��XY���a�yA��n-q�b^,c�hn?/I6&�'/I��t�@�,INu�
,a�o��Y�%ኝ}k��V�[?[�9�� /�Xe�{���+�ݠ��0c�q���#�(C�z�r+�nv'�p�pD_����6���$�0&�l�q2��&��^<��'»�ɽx���:�I8�Yڙ��cG�����||9��L��'�3/XwVFt��V��WOt��<5����� ��Q��z�:c��IL����<H���t_�<����fu����hk�[����"�KP�6p录���eT�sP�m��;��8�H#J�&�xn�`:��$7����$�$�C'l��T��&Nز�� ���4���U�x�7r홳�,g�:[&�whGC�x����X�7��o�&awX��j�f�L�Y�*����rt�%�"��6�=�S���ɇ#��2�z9ae>�4�Y���Ղz�08�ɳn/�V�a�.2d�Vh����+��Áڔ�/G�Z��8��˱;f
=�rdb�}��i35U�z��7(7�$M�~6�=��h�½���mT4��o�R�Y���o����"�09MխA|a���K���f��/�(SoTB2�sbq)ݟ�]G<ϩV��ZUėa�L��O��6�K#;�E�8�ǘU�!�ak�N�A;���+�zu2z���q׺D�� u����˸F�;�6���R�{�X�@���}��6lGx��=a:`[9���'ܬ����_�`#��9&C3O�X�%���g�tx<4����׾�Q��D��A��QޓU�;7O|c�;��ͬ, У�YX��l���g�w��QΏ.�K�|�ʛ��#���ȸ��H�pb]�`Gz�A�y<����*;$��=�|�s<knLp$�E�9��v|�0�{�pٗ`�p�9d��9%/�ѥ��!1�_����WN{6�!��+G`��X�QsuV��W$�zAV&�2O,S"�\?�a��db愭@F����g~`�`]a�㦢BW��~�T���Ҵ��K;�7.���G���Ux|f%�>�/B�m�0��0]]�%�������/�fI~�Ś���fI�:ӌӘ�h�:j7���D3�nV�9`e�@�5�N\�@7�5�6E*���[z]�,;<aaQ��Yfl[I�e���������O_Fi0R�o8�����3զ����+v\��8��Ӻ�|��'�/���ֈh��l7���'��I8Ұ/�զ�3xO��!"Cp�D�� ��3Y1p�����M�q�WE��-߿�K\�f�e`�d����푺j��R�Ym�0�,t�Y?��x���F���8xt�n��O�YR����gV-�X,�5�Z�=ceH���?�Q��5�2F��(b��;��>�	;��ՖǇ�[[�Ŧ�Ul�������4|��	��s¬b�����1����s���F������U�p1?l����B>x��7B	ĩ�|�Q(�L3��&%`u����p*HuI���/�T��q|4B�����Ӛ8�6ԺT���l���YR��4��_k?�`#�Wb��6!P}%�v����Wb���j��&�|1j�^I��[��MZM�${��[�9�r�^`���\�WXx�T��m��JffF&��Ӱ\����Ra�U�Ŀ8Y�Q����^a� *�;]��+l�kWh`�Ŀ����(qP�fG�������C�����^�hc���˗�
[ZY�����\a�ҽB�����Hb�\܊P�-f��[�|��y�����<w^�t�赓�F�I2n�>��x�Aڤ:�8.�~�\�I@	[��������ǜ�3<���A	�ˊ�A����Z���'�uY�?��̳�8�Kt2�r���Bׁ�\kX	�C&����:��? K���� ���=���~�C�� ̦��y�tR����j�������S��{r��P�O�d�/�v�|�����|�~
F��O֬��A�k<�L)YV�x�	xY���e��z���/S�dY3Z{ ���u������������1�G�j�-��6�V �!0�9�-�c�k$�m�*��|NRS'Ǿ�A��4r��Gǭh�`<����h����v`Hi�����k<�����?Z���:L�^�+����9�Y�N�':�h���f�y��XY<��#l��F�Ka���'�`{����K�,,�0mE��z=Vb����|F4��hR���v���q      x
      x���nY� ��|���B� �eȤ(J�l�b�R�&���%e*w7O3s�R� zЋ���2��( 6Y�\��IɜsϽ�~��tR�� �ͮ]���6u���t�QΓ0
�¯���ï�#��������s��������/��n���k���s�8
���~���u���⧟`=��^��ּ�5��t��y��N�SU�~����'A2�x������?r��#��'��ᛑ��?�`��E�&��Pޥ[�4홮j��W_��n�R���M.#��������q��Y8��6.�h�/�8��X�ȟ}/'~2�Ż�=x��ȟ�)m
V�����p<F��C�{��C��>�����w��ţŇ��e����/~z�� ��Y����^��hk�(�<�r��������=���:��ɟ�i=H
kDiM�'� `?[H���̒�&�:_#�O�gH���p�C{��o��t���"�+��[�|�3|��Ba�G���z� gmrV�L$�Fި5���fE(�6L.!��=�����׽ �K�����\v-�
�J��"���,N�Jѿ	`-��w��j��F�J�r��5j�fA�����E�Rbg#���2�k��FAլ�|��x�'���^C��p����ݚM�-�N���m����z�^�B����V1G/ t�4��4Z�� 2�27�`�N��������WĿb�i
<i45x�\q�W~�,^�M�M�������ǡ?�]��ΘF�e���Ҥ��G���l������5�[��h�&y0���b	?��y���Ŀ��R�ޏ7�[��ԯ�9�`���������K#�WF�����CZ��x��~.�&�X�E(���>����w�O7�$cOA�8�H3�OA�I�V)H<��>�'99
���j�׃tj�n�B��q}�$����*-����
Mѥ)��e��XR�{�C���7+�
�gG����Ss;�Qc Q��0��yͼ�e����Xo���u�F�����Y���kj?ǀK��#l��Fӡ�n*�l���,i���Y��cl��Qc���,����K��X�������z+x7l�'��E�W
��Q]${�{�Tg��T��:���ƣ3:za���:g �(�G�⯋���óC����Ll��OB@��̣ ���������E��2T�swt�*���?�g�M���l�˂	���3zM��DHqE��Z��]�I+ǩҽ��y�t��"�jM�"�"�8uD��_u6���#M%Ǐn=:cq�^Z4Y���jaPs�
t�j�R6U���-$�q�M�`��K�]O6�ĦQ��9�Q3T����/�	�V��������L_�#v��g� �0	�`��~6���3��:�\FK� �����#�+b�WLb�h��:���x����M?q+�D�{i^ڎc9��_W���Ku�1��Cg���Z������eř�wWa"d5`����J�8����6et]�,�S�3s�jgW5]��\~����Ч�#����tM ֈ��(!�����3J2�G0�O슥:	l`z̀zYtEІ�������3�M� ¥���/ψU������j��nɃq�2�?<2���//H�Џg3�����*�&�B[/nq|�PmU�4S�� �[�gz��̡ �y����#EgHO�o
�̸]Тk��!����$E�N�<�J&�K�!7�"���M�/�
<��J�̶]Cst��\�F��i���m����.5��ҽ�k�b���Ba)�ʱ�ѱ��-:tU*`2�y$yۇ����L|
<�������Th����',�C�M"��J����R�����{��D��.�U1��!����rC�R�g�b�ve3/�7;�����V^�Ő�(�}_x��ȏ���_~�W�Pq%c%��:�Z��X���(�x����a�w~4d�Py4T�����ߤ0^$�E:%nY<�]��j�P���f�)/��%���W��`�񟯂��Щ�d�M�ϩ�~������,Ŵ�n�W����k8�o^s2����kĜ�+bn:ksZ��s���P�Ĝ�����i�ݟ9�i�����i��K���9����B*�*��P�H
ee�'�lX�;���Q�l�Umcv����ď���q�Z�#���z���_}��[7�5�%7i�
)�+[��5�|�f�g�6[���^\�*m��;m?��+��V�]�_k5�kͪ�vO`�&0���a���<�FM�KO6�,���5/���f�- �u@���3I����Y'(��T@nV�&�0<��`��MCe�+�p���q�+Ĩ5q}V8T��)��3\Ȕϋ���0P�X��
�=_Y�E9˖Ã��]����Hj����ߒҿ�����h62��dh<�>W鋐����B
����	X5�!�U,��w��U ���MXeq����4T��m8��ì�ɄM��V�y�GLX�e��x��"/�8��yE8W�V�c|�5��%�O��))S�1-��c�:��P�ᮃ�u¯rkH?�7�:���ȳD`��ʠR��d�����F����{	�TI!�۬���	%���J�`S@2zJ+�I�MӒMP"{�Ժ��S��� @Yc�}�?&c��}�#v%��ɘ,�����3�2W�la�|-���Ƌ�j9㊘����f2J �@�?�#D%d�/��KEL����FQ����3{�aU��\m�n���@�I�د3�4KC�+�'����vբn�	ߍ�q0����ф)	����4���q1�2T��a�PA=.�dwh\��E+�q��r�~�eQa��O����"p��H�kK���j�ڸ9׀Z��M!��N�0�NT_��I|E��8��	��"ŭ���!4q7�&��{�h"T�M��İ=W(�� �	�7'g����}<Sf>�W���r�>�3!~3
'�_�7x�	mL����ځ]��6n>�*������k�]�.K�^��IH�ת�G�=�-�nS�럐^��^=��3A|g3�-
p���D/�*�����������IG/g�ɺ�[IG�7��.@Ҟ��s"�B���Ej��hQ���I�����	)Y@5�	q��g�gLVA�"���~��?���C�?f�f����^f�j�]j����_-�\�}���^�ۛ�ҮM/�n?�t	4�Vz]*���Z���w;Kݢ�e.��^�jާ��f�:�,�I2.�����p��==/�bP�N{��(4�D�k�}d�������t��6Y()�6C|�l���r�x_���N���!ڍ�ɩ  �+6�\��p\��%���?�!�~���Q7U�Y�o��3��C��c9-r�-������8r�)��%đ�[��>���,^B����I�e9T�Gn$񶋂WG��ѡe�}L3Gs�M���8r
��ݗJU��8��9:���-��������e�ה��X��Q|%_���%�Z�/U^T���j3Nߢ[wt%~�˟5J/��0�~j�*�=��6�o��b����N��������K�"��/����u���fQf����;vO��ӄ�IRP������PEG8H��s���.���'6di�YC���_li���1��1�bn���[������MS	D<eĔ�l����2
��T����,V�e�/{����~����򴰛b��(La�p�O���"�lʮ���x�%�b	#P$1�%�5���
��g���0}�*(im\Y�?��q�?��g�\N�Ӑ@�z#�i/��ϔRx��/3���z_�c2�-�p��{
�|�y�d�P	/�����T�iJ	��r��^��<N\�F��+��S�U��
�|��N<�-eP���������+�36�������*��q�xp�vpO�&��)3�|��G���x~͢`Ο���G�3T����@�\�2��#�A�����P?��J�
���3eʃ�pS��1w��_	F,�    1*x������*�9(PB�}	.�,!��ٻ�-΁�����Y��&�b8)���D��#]��XN(��	�*	��\p	�@�Z�8�^�p����$	@O��z3y�иL!��O�a���ù�����rx�8��ء��tG������^� �4繪֋$�D�U�HJmʩ��;�?fa�]ȟ��;�?��X������#��5'L��!;L��O�i�)W�u�'$X�����8r�l�L�3m�Ġp��sߌ���s�2	@E˔��Hן�v�'i]2�VXk�	jZ=��(�v;�edi�!Z�5Kf�v�)�I�x�O.�,�+���PQ�N��ſ��ٔcw�c����=�5"E�����p��� X���X	A�+�\�ߎ����:���#�p�n�9OC�8��Z�x�i�Sx!�4[���b�:��FՑ7w�+�Ɓ(>  �������wc)��h]j��~�p8�8 �d��tZ��M:K�t�
ڭ(�Di�C����[�ti�����5bŇÏ�ѫ󏘢����z��ɪ�[G��\�i���1:�;>$4G�5n�	F��P��E���>c�mQ$6�9t}q��,��ů��V�M8�Ʌ�ĄE�_y茍���7��8f�q=*�Y$k|���	������};#l1�Ys���v�SQ��c���]����]w�=<�E�Nw�����\�Vf�嚸��p�:���q߲��8{^�=Y'+;�����8������7&�q|K�gx�;�.pk2*g�Q{k����8�Hw�N� ���&��"�i�Vd-k����r��U;{{��ڟ0H`�Eab�U��Y��;V���WxbϽ�ar>
�51i�z��ƋwR����9��N�4��DJ[��):���ut��o��9k�!/��?�@A�Kb�G�4qT�gX�	�S�iް(�n�M�x��C(��xt_��nϋ�^��Pt_�S�����Uv�\��e}��N���F7�Hk�ۯ�F�yk��h��՟� �;�ˑ��\�i�y9��k8��B������RM��G}�5�yV0QR{���`|��F��ܶP�ă�g��r�ަ\q��+�Y���y0���M���t��O�V�4N˳+"��W��dg'����i+���F���`�ML̓1ˊ\��a_Z#n��x��M�ï���8�a�㒏�S��<5�j/~vR���j4Y5����2i�Ď���p;%wV��µ6��h��;a�w*d�!��f��

�xƾ��6#-���7#]�n�����::�J�7��E�OgQ	4k�Ytu�G�^��wݍ΢����΢=;�n[��=��!T������=%�m�s���E�& � ?{>�ߠ��F�y��W�QX|`@�A|�G���1Km-�F©��>/�O-tSFaG-ti�j9�GC ҡ_j�}��kJ�i��\�!�r�@���1�	��T��qL��	>�
<9�*��̩�J�v���ڝ�fv����ˤ*n� vs�pҫ����IOM��33v��$K�XwqD��#�湄y���:I�I���GD�b�񚣕�%�b;�fϼ����>��f��mQ�R[ԫ|#R� ��Go>)��v����((���S逊R!ծ�d�H&��|2
���O�#�|�wF;�29mv��2���΍n�΍�F��V��x{=��f��fXܩ��n��'�����
��b_�Y�b�M��J�%*��D��� 2I�b@B���@T����6�D=:��
�y�t�8i�qr54������:��-[�{nA�"%�Ԫ����P�e^�fA�L� ���P1�p��ė��p�.�������=�p����Uꓟ¼/;�7L,���=�y�m34�?���6�� �F�S��y0 豐n=<�a�P*�is
�<��~�NG�6��4�M��l���N#@��N�=�mkV���*�|�M��K"O��E�(\M�]cqv�~kͭ=r#k�]��b3��s8	��u��l]��޿���Y���2'{���Ț4h�T��Z��i�&�&�ޠj�f���6"��`�)��0�n?g?����(ߟ|x��>|����/����C��Pyu|����p�/������5�H���hc�j�.�5�C���R�-̑�ѻݩNNv!^��n�ԏ���f��N�`�#��鲑�����R�+�L��C8�l�ݙHn��9�A����[���+�-�p�
�s�t� �J��'\�`��S�`�0��F_�}�/�-�:��`#�a�ts������٘s��f��/~n�g�fR���?���hF���YN���t����Ie]y7��c��5�V��nR�>K��V-�~��9˽	��g$�쒧np���Pd߰-	[��3���U2�}��O��_�6����y�^���ҁϬ >��8�#�26��k�/'��3��v�����.~��4��s�Bh#_�\�A���*ƍO�����!�ؑ
�c�^�/P�8Y��V()R2zX��l�$��GY�7X��,��saKT�1����B��`����	ҍP�p���Ig8��p�Kw��l��%ķ���c���<��s��
����FB^�/����?����rj@����+Ə4����ST6L�k�� =@��\�t� 2�=��- S��R��@8��L-��s���D.�ዔ�|軌	<!�)r.����Ϝ��q�>���|�<C��Is������(��?�c�δ�^-k�+�$5�*�<��s�i�32� ������@k����?���f�.���%���״��#Ga��Go|��$����)���=�����J�# LzA���+�z�����s���$�| >� E��~*N\H�B;Z���t��$��1[ܖ�\��T�_��.	��UC�$f���4!d/пL1�u���D�
ׁ�G�\@�o����:�`��uH�TH	4i`_D����!A�������ϩ�i/346x������(��ካX�=qn,�v ��s\wĥ��8.�C���t�8S'$s%1D�@4αgN�gJ�����y�1~+t(~l�2�_�:�}װ)�y����#�La�|K�hi-y^5����.|Q�,	�T��R�S�qj���A�6���YNa��gywjm{fe�$���&'i��}2al����g�Uz4�+�@�F�g�Ez��D{�ho�m��M����6��&��D�b݉	�j��=0��f�щG9��Pm�gr¹�!��ς���udٻE'z�_d7 M� �t���bC��k�FrV�����YW��G�Z9}�
��\\�S55�"ݴ��B��܄J?���FD <�����?dF�|Z�f�o�մ'�?ؚ%�N�V�-f�������jɺ��_��R�l�J�x��� �>� �=�tLg�c� 
��g�cM*���=�F�:+�F�+�B���2�B��TtC���<[�\��(]�XЎ���^4���g��O���BF�BV�B?�ƚq�i�L��8 �� �x�Щn�j�8˽�]��Ӻ�^���
4����ۅ�S���A�0%��Sl��n$N�4Y$�JR�	��U�W{3�R����ت��*"^߀�7�"^-�x�Kě\��,�k�J5�݉w�E��K�w�;�ﲧO^��e�^�[���"xm�MuA����v�J#{r�k.ɞ������ �6����Bn�w�����U���5ȦF!�p �րE�b׭���րE� �JK]k�Ͷ� �UZV��:c'��K�A\vX�Ɩ�eM��S}��V{�Kc}yY�^� k.m�}�둼���T;ŝ���e��׃-x��Z�[k�R�[^V�lt�z�piط���Q�ت�
��0JւĲ:���������e�[�Ѱ|���nV��u�����D��r嚷�r�FkfYۣr3R���ʶ�����jп�rkZ���X�8�; k��[�w������yw{u�p�0s�u�Ί➽��{��Q�Q��rq��R���g5�ih���`���^��r�¾�d+�ilcЅ6�    �B�����~�rþ��.u����ӏL%���/�������~�b��S]���+D��<���_b�Ȅ*,��L���_L�|^��6�ÎqW�2ج}��;�:��9���8��<��a�U���<�Y��"���'4Jͱ̽=qgb��Ũ-�ˉQ����ܦ�kxC�5�~t�	a&�n�1)爭�,��/��b=��	�o\S�ąi�US���,�=�`l16�m�ŕh�(f��
�c'yƵy	jl�vɢ�6La$���'ױ��:���Y60DQ����.��d�Q;8Q�:��^����n��w��CU�R��>TU�,�&��G�!n%��,�A&q-	" �$Q�p��9+F-#^Ɗug_C^B���G�_Ae��S9F-���h��p8,���<�c�&����j�+��x���/J8O�P(H�_;u�E����w�V������6���ؒ���(�����좾{$0��l��+XɄ�Z�a�X��� �ψ��2�H��$�טQ٬h��o���O�@v���M �WM��Lg����b�~��i#��i8���w���/���QՌ-��f��o�L�W�r;"�UeB$r��]��D��NDZ�1�Рy�V�Z�����a��K̊�o#�&�Ǜ0&s���.�|��z�U�<`L!�m����)T�!X�0���F�#{R����0P>���>_)a�Ƹ������l(��pNp�Q*|����`D}�
��p-?�(����~���r���?���g��0<6\�� �g�3��3��9����|�L�C���m���g[�X2�ᗳ�
n\]��ɕb�])fx�V\0�W�y3lg�- ��-��2mw�m�U_�7��p���i{�4��J{��I�ud:�[0Ui�]%��0o��5�Z�T}�]�}�h=vI�,>"���l55˷�"��h������f�AJ��?
gI ������Q�[�ܜ��fTD,��D"6J�!qa��������Gu��4���+2%��>�mԠ��Z:e`S����>�9��`K1��k�;�M2GLn��?F����%��&�y�7���e.�Y�0����\��K?���E�0����<�fl�u�W�G�gr^KȻDeyIa�+Rꀟ�#|�!v�Jp$�H�>�k�O�M��S�ޟY�k2����y2QJh�&(�O�Ð!�p�@Z�	������FO���N����ݳ���?;�O��e�������Gʿ�Q��Ԗ�T��]����!${L��#�;T���#b`Y4��V(V���~G-��Ӹ�`1-���c�z�>�>Ο��y���_��?�8w�0>"lB_��A�b�S�}��&��ϕ�P��{ ;R��?�q4�?�}t8� ���8#'{Zz8`^y<]�}�"�Ƌ��crc�I�p2'�S�f�1<�q���ȭ�o�N�&�!�H�(�2��̻�F�-L��X�G����5�8�'A�x��� {���8%������M$�{g��uP��S��\N>;G�&? |�8��3�?��ŧbӵ1K'Ǽ�bP���IPʴҩ�@C�;�4G��(5=�S��~�O�
X��X2'jƦ�Q8fف��#r��P=滋��=.�l���pz�㏔��Ҵ�ܑ#��<�&N������ZN� 9R6	�F1�	��!_z��Õ����ف���J+���`��c����p�#�|��h3x�D���Q[�P�[���O� �T�=~�dS��E�\�!ˍM
����M9,��o6�Nl�wА(�qL���Lr�@4���~�h�U��oxs���x���>	��I,=�e�VʊPFʾ`�N��bh�h�΁��|+��s,��Ö���||��c�����؍��8�P r^��R�yǔ�qT �1�{"�8�n�|��!Q���7L�E�G��at�_��&�����5�=�t�F�_/�wbM\>}�]�O|2P^Q��9�SDg'^\���$g8͗������BY!�&�c���a����E��N�w�	�8�V��R�}`x�K�'��gN^�3k>����d��}�Ǐ���g��R��A�9:��ZB>��V$��L3���
�j��\K�,M�˽6�,g)Y����Q��
�{g�k0�J����<3J��e\��.��I�^+LN���k��G1� )�G_>y��G<<Nxk<�ů�6}�B%ĹȎ�1�\#����)�DQ�h���e\�e<��P�nlZ�������7��׌9�Ɨ*�rt�x�4�Y|���OvIN-�X��i#$�O\�b��-��D�1�^WL���x,�a�_����N����=��.�@�0�P%����ӗ��qE9���(�t]Ԫ�YBS�����,���X6��,Rdf��Du;�cXw$XXJ���S$!��K��R�o'����������K��_�*�6�2h<����>�@9f��1ޘ�bʫb�!�d��p̳0����٠��	�pyJ[�@��rǾ�N��)r����>o3/����u��P58lH�Z�u4�b�)i)���/�|���&+'ǵtШ�Ϭ����8C7hx#NZ�31�����{�� �E�re�-B$N��8R֘�,�_J��B��)RG.�>"py�){`œ� ���<
�����ˠ�����z��S�\95�qir�I�AN��O�i��(�_Aڵ4�pĲ�uJB�<�|����3/���c#h�"�Y�ny.�*�/A%����Y��]��;�]|�LW�#�)R�g'�,����&�>����u�f%N��b���D�4��'ዘ�h��I���U&�[>�p �k�k7|K������r(5u=�,����c���)���]���%x:��84E�����G�/���#�����b�ҸRp{���Ҹ��*��Cm��;�ߍK\ ���p�Ng��BJ�~���G/���'�[����a��Q�*�V�I|�|*A}$E��<� �ȱ㶃�Шۄ��~z�F�#TֲP��)�,0��;��@���'����Vf=��f�j>����7�Vj),N��Dv3m�t΅��3����]�N�5��q���,�Z��pjO�%𚘈}7I)'n�l��@�	�ϧV��|(1�NS�ɺ0(=��u�ե�x ���M�P8]��	|�\�7?8+�T"*��P���a�������Mܱ�X�F�ؚJQf�jV��Y�ތ���!so`~5m�m��@¼=���\����l�[�Ҙ�(���e�I֋�O�aO��n�����>x򲫺E/��W:�d��3)�Э�5����G�ڤH)zQ�&��c@sɒ��&���5�%�%���^��(Y��y��Hvć$1�G��WG^�p��`|����?��lr-Ese+��W#r��n���$����qߜoi����g߄�g�]aD'^��6�Z7Ќ�3�o�a "H@(�c��4�J�H+������p� �/�E~�/��SJTf��)fi��(���CA�w����@'�=�lML�R
S���]��#��G>��0S��`���I�Ot�ѱ��p��g�4	e"\.~�1��)H험t=)�B4�o=V.NN_}�8z������~0�
w�ǬR��3x�r1�����xk�Qn��@9��|��LA��<�Q����Ρ;�'3	�[d�.~Cf�/x �OI�����!P�	L���2xГBJ��>Q�������� b�)|iB;P�f�t�r�Ԕ�C�b"r��e���OO3���wi>�Y`"��zy.?�2DM���\��d�W!Z�%������t���"��'���#j�� Q�1O��tcʧ����R.��)Ë���M��f�q��hK�(	Gh���0�E�S���_O�9�<Gs����W�6+|Fa#q�p��I٘T��i�E�p�zw�������y��%˧�C�2���S5Q��(�O�B�������d
 ����7��d��t��v���#]`w|�er�    �CW�Gn�4�����p�������a<;w�3����\?C�9	ɴ��d]1傉X�r>�����/51�+ ���e��d����R�zc6WX2<����h��b�h9E�5�OD֟R.�J �? �c*��e(�V$Z_⬭����
{�����ؐՋ�%���Oyg�c��4�9eb)S|�x�"�Ȅ�!�b���'��r0'r�y�'���tQ���fCB�����o�n����U�̇�Q�^�W��&�)�r���E��|�+^���#&�� *&��a*�S�7��?�j"�b3˟<�ͷS��kk���@s�5\���&Wce�;A���eOU������ ��Q�g���hT��դ�^\��h�w��v�k{��.�̈mv*R��k��=ܬ��Bg����{��w�K��n=s���J �B��I1w�1��-�[{��S�Ʃ�+og[�G9!��D}jJFc����S�Դ~�ԏܥ+�����-Oo�s��%��v��̵"ګ�y��Nm&�,S���x∭Y��t"��W������d��N��\�u���*��1�&#�����1oJQBx2���+�l����C<�^�#���T�g�l�C�R�?�`��l
 ��	����U
@��%*�%,6�M��<���:Bس�;g����VحEiC��D�f��Z�K.�֓���1�R�C������%��,h0������0c��7�i�7�O�Lo���9���h�V���J�� B�{��"��{����l�"�ƀR�Q��uZ��}�6���TJ?�$�x�0�RS�|G�����?�Wۂ�o�I[U�2�am[�l��/Wֺ=;p��l��<�h�ӂ�����-���)���-@�"8��B�鄰X��0��m���r-s	Ej35�(؂��G����01!�U��3L�²�;5.)��m�(6�^��is8a��eq���	�r�?W�Rg�cK(r���p|to)}債�Aա�_�}k{�P+;�P�L���O>��E��gYr{��_���.�W;,��V�t�߉�>G�ˬ���(�﯐�Њ0�rj�V��X��L�Q8M�9/f���%����d�Al�����t�JkpM,]V�*�p̀���SU���9�Q��'gXz�8�P��S�BT�b������i�唶~$�.��*UJ׉�㽇�S�\�������B�-�����Aw�^,�O;ȗ�j��cuВ+E_^;0;A+����y3�|����?.~e�աL�}y�ꄲX����9����r���n!�E9���%c�� �-�h��ˋ�Nw�\�����,��μ����֊h���#�"^b&�2��+�?����D��DїϮ���ʥ��3�u{���;�3�x��%AP4�%���D_^��t�ʥ��.dۯ�_+��g�O�p��(��:q?��{�~ &������Y�Kw�_�&Tk^��L�i�����e%|��5����+��!����B�w�[���
���r$AԊh��b.�)Mu�hS�A��7�@'W�����wzb��=T4, �)�r<G��A�j��U9�y�J���1UbO_
P�'� F|Tn��G˓��҆+T/a,���9�tw;����b��q���tYp��c���s�k`x]�m��������G�e�N�㳺��p�� �We�|�¥��ǒMT���p��@S�G rH�ZW�j_�=Jm�j�gy��[V���Z����\=yz���ۓã��Oϟ�6G��s�&n�GU�Q7�()���	�3>�q���t4}P�!��q��/IJs���~��?���C�?f�fǪ���2��El�G7	�N�=m�Ϙ��7��V�1;U�ΧpZ�7�lr5��e��>��u�+�Լޝ[u#��Xn�U];�%���u�A�w�K(�B�m"\{�[����<bF��x�дCo,����~�|D�l����hS8���}�ߚV�q+�8��px���qW����M���[�4nw�%i��jy�L�k.`u��|�M��D����F	�I�ٱ]������m\n	|��2]r��]]�k��L�8$2ט�@����q�}�WР#��9jr��-�	\�zu�k8�kH�jߢg;��'��{��� J�)j��؟`o֕�K�DK�'rY�~@�v4���4'$���Ћ�M�藨j�#2�!-��k���{K���y(�ch���F���v������v;zb�oq`�\�4ͩ�|p:\��Є�%���W���MXr\L�M�5ʩ����8 ����AJ�0�d�3b6��|��	��
r�Z�M_�p�<t:��� ؏h�N�{�K@Q@���Va^ys��U��n��{-z�oxB���k��#�F�^�&9�*�<yB-��k[Z��T�8��]10#G>�:˙7�4�`���8 Ƥ����7�S��E�ڿ��ՙ9��,o��<t��G�&lMy�GC�8o��O���&�=���+m��F�� �,my���,�F��7����㼨�Yin�gߺ�!\�5���oؿ�����*{ȁf�{<rz�]^ �*�Џ�%�� ��5���CT�:��}\�ŶE��t��F:����{�����&U���~$�� �8�-�C?o<��|8+��� �p �����i������C��r�]��$���4U��V�8�j��(�+��D��G����#g��}���o���N�\����Kr��Z��J��ʞ�F�c삱�/-�:�-���vS�m�+k�#��c<4e����I�k6����-�;��'k��������SntT�J��Ӷ��=�vF�ѵWv9����@��)��ׄ��6�-�d�M
 �����>?x�?�q�iI��V��?�/��p w���
�1xD��+��1��P��fW�S����$���'��0F�tԕis�,]T����:���!�[h�ֽEJ,�u�����; J�{��9�ʢ;�б�N��^���U�ѯ�����f�v}u��P0Tr*9M����c���.���xo�sf##��d�W���j*зM3��⻨��1T�:�:�67����8	&�hݴ��`�u[qu0�[mcn�#s�u��q<g�Vx6���s��@�����ji��J��^�����N�'a����� r�8N]��Pɦwܮ�v6z��\����}<��h E
'l��m�x��y5fH	���O�	I���{V�����v�r�� j�I5�4���B�
O�~���TǸ�����z��xwgs��4��E'��o�Cy��n�}$�ٻ�0'6�����&vծ��j�o�X1��2r�N޽����ӣ���|�H9S���2+���(.q��ռ X���cK�08|}ܣ��f8�C<���n�Y�������<���m�Ԅ��'8���(S��z���33�<��ң~����+wv�׫����զ�H����#���TՁ���IB,.����U�t�Z���D��Y�Ds�0�a�y���g"Κ�O_���4��uTs��o�J�v'}W��=:j�ٳE�����i�� �M4�q�C�_��O����ݠX�G��ro���#쁦$U|�Hċ��OFY�#�2�[}��	i f���1�����;�a �ۂM�t��x��ti�s6E�s�ݎu4���찚�VlG]������U䧼I��e�&N��L�lX� ��S��vS��Y�!.��M3�0���^�����-Ѵ֗���]o�m��Ҟ����јշ�a�MaO�F���Ϋ*F�T��<W����0������ڼ�T֒H�;��Pstzj�N������Іgl|TI���G���Jdv��90,m=E��^��;-��>��:%����J~,JR=��)Z�{[�DX���Q��m��9*��}�z�]����.���W�7�J�qe�+�51W�w�tJW[F���=���`�U�d��W��;����    \��a�넮L���r����fp��c��x��r���0�C�<��G��|L	:��� �؀�َ�^|q��n��-!�R'�&�L�23�f�������u�o�bD؀Y�q~�_�ae��ktȔ<���Џ���DGtL1�U���WMRl��S~�]IbP%�����P-��
El(w��atY�E峹o4� y�ѱ��@oK���qϣ<�(N�V���fŋ.� *�8L�G������+cu����I�W�XZZ�"K���a�-�ZBQɯ�I��l`C�6}��ac:���\�Kdsq>����{�B��6-���+G�W�OS!��2�t� �'��@R"���c	,pl� �
2)�n����Y%.yP�8��[��) �+���?�r��8����˽مl�aE�:���B�)�^%a��8q3LIt�J�xt��J��n��s
�)G�n�n!t!�ֺC�|9˭j*�1��C�O�̕��Mp���)3t�����k|e���e�s�7���_��?��x�/\�K6c��������+���9���$Њ9��7s�7w�����H�W���w�=N@����s��P^�!��lt����b���h���|�*�h�;�E4bWn��)\��Z&���"r�i^q���	�>���������a�]u&�W����6��y�xD��>T�ga�P�I�-�1��d��ú	�z�"�m��.�l�,���\��R- �ǁ?��wa�U�.`����_�!�I�n0�5qz�>0v/x���;����bW�n�{�̠�r��aP@F_޹��̐Kw;w�E�0vX~'��E v���>"D�X�P�	�a� WĮ�	�T�f(�$������qV�g�WK����8v`*�+rSyF�
�,j!x��-���]1)mDߢ��p�%� �Z�30ls-߫A�(}y�kg!�X����>�������fP�X�!۩ʥW����C��´��1���-��NԮ�D�]�q�l�	�� ��ɬ�G�47��������H����I�������y�a�?S��|����c>!�������S������\�*�2	����T �#��x�?��W�ä�x�����H9?9"R�e(.^L\(�Xl�(���؆tK��n��޽�p��[K��ت�)P��X>����Y.�mH��CV��Ԏ]�
0(�d,o8ufȥ���a�疎��G xJBDJ^%�#n�L@:��c�6C?J��h��U��2e�v�� �6�e��~����4�Dr*�1F'���f�S�h��M"��I�R�G@�b���~�
��F�{ߠ��-���{K
r��K�\�
���&W�i�	o��lz�oj�%�{�B�|@�1��ٻ7����r�
��R���9�1�����$���q��/I.�m�]�R�-1e��'��LM��z��$O������c�Kw7ک�J�ƏU�X�͵5c��W�i�ާ�!��ц��1��=]���uz�RN��_Z|Ӯ�8�eG��ύ�Ycw0�O��Yo�Q��*�o�c���E,[���I^f��%��)jZe�fS��Y	+��T�^V�K�Ȧ0��D5x���wQ2�R�/�K�q,���K��՘~��C]5FW#}�5_U��(���L��*Dl;%䡮�a�wr�
��j1��>���(�o���
�)�[bT�\
9�'��gN\���;��T�,�t���]�_��v ���q���[�k�g�}˹3x������d�yv-	Pd��N�"�>�ص�A�'�^ד�9>�Ӓ�3Ug�btA�V._чX�n���ͿY9צ.q��Sa��N���ia����CԚ��mW8>��=v�P�Y��8��a�A�o����~����꾖~���<#��,���ъ�a�A�5�iK� �$��zGΓ36���X��.�y��%�A.��T��M�+��S����Ո'��x��q�"�j�ś���M�e�n�h�jA4	��cF�d�#�wW2�]��F2�C4�����%J����t��R���Ͷ�fa���t�;kFi�,�J7'��L󰇨2S�쵬(�������4�*]�����ՅU�Z�zYU7��.+�-�0Zn��r�\��X{�dG��$�����MbɭKy �X���� 7'��]�u�����V���~�M,��˻+��;K�m�Y,�e��k0�� j�F� ~�I����'�� 
ke>��`"�ؐ�$O����s�琻f�=�W��*�e��j��p��X�]�}r�Cbk-�W�;vJ;���akGN�v䕵#Kp��j�b�(C�;m�"d���i82_hw5�n5q�Fc�ҩpl3��A̔�p<������i�ƿ7Ars����.�o�,�G��ADWlH͡ZZ�l	_�M����,���	Q��%����SXOk�*�Eo�`V��z�I�b{�F��F6��#��[m�F�yQ�߭��hzO�8��v�)����o��pK��v���F�%�W���0}�K���E����� on�w���;��,p�7A9|u��J��L�]˿ (^���B��G�U$*+�g����dN
��%�M�>�j�F�>�myaG�VN�_c��vK�6?j��v�Ini��]6^���$e�z2��jBM��9�9TG�8{��=�c�Eν9��vE��v�"g�#�ř�O�YN�P����sJ̩y��.��	;!onǥg5	�,\���aٲ�N=,�Ը9Ϟu������j�3�O�~�gO�=�]�dݭD���԰�O�^�S�Ҥ�S˝��z�7��x'd����H�i���7Ox7����g'�ޣ�g�g���3�L���K ��a�r�'Q0Y�m����Aְ��z��)O��QdL�e~�a�?�I(�O�xBB�@9zu�~~<~� FƗ��;�D�,~��O�,�dlG65�L�ES�mԷ3vǦZ	����2����!蕙e�&i�Ӻ@�M��n��f�B/Y�@=n��f�B���(A�N�Ã�R߷�V��ߞb-g��]
�$�V��^An�b��.����h��.���g/oٹA����wȬ#o�!�~��������.�ːb�t�����9��̓j���w�X�A�C���P�)�ֳ�w-kJ9�=xn:����G�{���ں�$=;�r�5D�8��%�mq����ǁ?��w!�%\O��j��6��Ֆ0�Pm��Vx���rl���$�������t:(ǀ�$`�L�q$
��l��˔��ߡ���7���z��'3�Rm�Mə�Ud��U['��;/�ܻ�A��B��/���	�W9��9��'�j0f�xCݡm�V
y+����2�9��ّN�^��|҄�xs���_�)�5<[k�r$h��l1J]l�Fr7�%vev��F޲NRy7�_�(l̿L��Q�K���(̑O��I{�A�͐�{Ub�
��w�XĮ�GG���-��l���#��0�)�p"���x2�
y�8�B��J��.=ڥ۱K��<,�N�8�*L���	�3�k7��*�GG�=z�{��qG��������ȕ���ϵɵ=n���9Wkl�l�/jx��&T�%-���T*;�b�:s����O[�=;:��mj����X���U�m�0ES^��a�\*�,Ql�.�.pG�AxZ2#�a��b>
YL��
�Oy���W0�*B��<��z-.���W�ڍl�}˯�-�I�k--��r�IV�XQ`w��)vkn���ӕ{;6�3�ގ�2���N��ގ���Tw�;�n߽��t��7Q��Nnn�!k��%I쮷!�ݝhy����|��4�����UL�`�c�#�ne��	h-���rm]�V�ڧg�^�mR��8��5�K���B]rM�v�D��\�k�;��]Sk>��u�H��+�}�ĽX��J����5�W2w��>�E�.?�b\�3����4���O��v5>�0]m&����*��]�W%ߔ����x����?GA�ʕKpu�)�ӏ�>T�o?������Ko�jޏXh�W�#vAkY.�9?�������[3��#ڕy�-���{�    
 
}�my����5EO9���/��|YMZ��M��H�n�yޗ�tq����E���}���<W�h�9.����t��3k�CnVgJ��ic�Ҽ�����]w/s�/���Y�W�x��2�ܪ���ϵ����fvʝd���07Zu�^�v��;%��{&��+�1�&i%�L��aiUw�
�i��CV��Ē�ۜpF}��	+�!�𶄕8�f'�~:��"�F�n?dM�R����O��ƽ���{�75DRv�n?�C�Clq��e~^(�\3��V��t1+B�kR]Jh1�nZ�/O�%���b��4�\����5J�Ɍ���M �m�bix|{�Lg���l������X��V��C��ت���}*/�8���¿�l�e��-�c_c�Tw�܃�,��h�-YkV�����m���t=���hhZ�e�������uu�^�½����h� TC�U��LU/�>��gz�U#j֪$k�5��`["{�j�4M3]j�M0�I����B���T-^'�m�l�Z7��<9�o��ٷ)���uڔ7�*�}��ͷ)_:�� ڔ�T5`���۔�l1w�ξ�&M*51�}޻���w��h޴�냪����+���w�]C��!Z�݊(�����z�s����?�eyq����W>.��pQp�d�U�mo:6��3�2��X-Mp,�EE����}��bF&����\�y6�#i${�K�ij`e9S��K�:PlԔY�'� ��zrj�ڣ''\e�ޖ T�Y@2�'hk�c�|k�n[�C4����%*;��o#�Tf���T�'�޷��m��~mZ�뷆�LR��o�TאA��G�@ �Q�!�Wf�W��=��L+Ǧ�T9bQ�D�6�	摘��b��C���>�^7��v:��}���Lu�K݌�K��xNc���32�+�t<⁅S��o�x3��?�i��Z�'�(�W�G��<.exΟ�	�d�j��l,���|��e������6����
Y�ʰ���4N�9�A<� <�Cdv[ ��<S���ў��mǨ��A敡C����*tL��s���?]��W�rx㏃�A�����\�U��i	E���Di���9b2 \'��o𶛇��ܑ�BGS��^r:J���U�c�eࠒ��a�mя�}Kz������!���k �t�1ʻ��g@D�>鶍����coY���g��۽E�lss�q��i��ݼ�ځs��c��%��u��w���|�X0�6�aұ���oؐ��^�{��?��8ٚ*��O�]Y��=@�e`;�^强0�>�5��p|D��Ek��n��G�gt'Y[��1����/ʛ9�M�|�� ��^����^0�L2����ᨥ�hv���k�მ<���\j�Gm� [o�|�mx��W��x�k۔ʜ�2i�4k-ݕ�茘�@�&���g�(
���l�5d��w�0�h�x&AMp1
�a�J`����N���*��<�؂��4řl�,���,�g��� �{>N��臩P��1��4T&�tNC߮���o(o�c�����9�x� �'O����e�0����	�3C.+@��<	b�}�e�B �(�`	�� Д����.>������y2�`������бK�P{*���mH�s�m(�3�HJ^�C
!w����%�v�i�eȄu�˜�6.C��cuI"���NTy=�o�?/#v=��� Bލ���+6$���p�.Qd��W�A� ZzҔ�� ��0��D�;^Dn���DbWn%���
��+�_��؉���*4��!�2����P�Ff��uQ�EO��G�f�
��"u��7@���Lt/�J��S)w�Ǐ�k�)�cb;\�#�Z�IN{;]J{@ذ[��6�NXƲ$�Y��<�^1Ε�f�F���׿�2��Oy���w^�q�D���P�2�\7Q��!��� :�D��2�[xjkx�:�i�<�_�]�<�x'
 ��b�մG��/DlC��M��s�ե�8��J�������R�I�)_�K���ed���ߖ����ژ�m�Qm,�6�t���gC-`��[��ؕ�E�.z��P9�#l_�ҏ.ï>�9����?�����`C$I^:��ck��+�c��z�ƿ�&�o��n�C+`��[�E��k(�g[+��|�MlM�|�^K�Cjb+a|[Ml������m��Z8|�v�mLG�۔�ۊ&�-n��8D��4���U۳� �C�mqVS��l���?�	�
�t�Z���`'�|��D��:9|}"�\�]laP3[ۏ�`� B�C�׆ж���1�8V�'��>�x7�g2z�ĠgM�I�׸��(Z��tpoە?��W��"<yΒ �v~r�L}���0-���Q�nb43�/��h���Vu�PS��ɅBy7�$����4��5{Q��䣢��تs��B�£�5=��{�N���?���i�a8hn�X'V��QRl�	��,}�!�"�^g�S�b�6Dߜ���T��{�C��&<��p��I�ߔ�r;&Q�
���ާCS�k_���gF#6�w��7,"g���(3��[�;��K��M�Ga��<@�j�+���^��j]X���^���mo@��d�U͆p~8�˧�tZM�������u�n5������n5�V���'�Ut�nm�cT��0���<ts�z�٨ir����L���(:��<�CWf:��\��\.�h�y}ڈ���kl�@l?�+W4��/�%�m��c�[6K�]�V5��h�-z+�!%������$�{
hl/h8�
��^���vUXK4�e��Q�n�ݥv	~����1v��q��C�ʂC!���8	�ʹ?[>T^�"Z���u���ېpuh���o�|~%F��֊L��-��F��&
#F����~����䩿Y"�4�\']H�{,sx~޸�G�]|�z�/Y��b)6�޾s�!S�p���z�5��������l�8��|x��EXGz/�N�h�d�t�v�E�]��&�u���p���:�4�� ࡇ\f���^��}�+�)+x�(D���N',W?P��ޙ�B%L�E������R@+��p���q���N�K?f�$F�Sq�ِ`�f#r$a)��e��0�t�5a�mD���-|3�D�`$�����W��O��� ���r�-۲u鶍m��jn��&_�洆�$�*
�낂H��q�"*�Sؘ%z �";�&cߪOD��`Z)�c�n�d��!�k�u}�Z�Z��\���T�G�-�#W��y��&��$��;W����0���(���]gX�y�3\�FXg�? q���G/E�,�0��(Dv���B�����L\�Ћ(���dj�g��xYF��~kpq�k�F�g����7�0���<;�3�V&��v��k �"�[��Ow\*��	!)�k��w���B�^�u�c�@���W���z\�C���#Ƒ����;�o	�%a�p3��8h৳J��,_bH1
n�����(ľh����sDv^g��_e[B6����.S���բ��h\�<bԥ�ŘZ HV"yְTE�{��'��P�L��Mo$�u4X��ksh "��̰��p��t�#��6�i*�±ע�W�ے�6L��2�QG��Ä4�`�y��
�\F؇�Z������\}�ե�P���cǚ7*���8M�jK�R�/��?�x
��T�QIA�G	��_�K,��t�2�h�3�e�d��d�.%ג��TDܮdE���W�V_9�b�|?�-b�=����V���R�4S�Z�0�ݸ&5M��¿ ̠A��G�a��Ei����|�;F�lkp��O@]J���ɏP`�HHE����Zx�?L��	I�V<�������#ڒ��/l8Oӕ�H- ׍f�7��g+�E�_n����q�7E����]�h�sS�|�<ԯ�f]�Mr��e�T=�g�_��:����D�$�?B ����/��C��F��Ә�D�_@�����+FR�����`�{q�F#�`�AB~5�h�    �F>{ �9"��:��.R�X�S�.����[D�-�y�\��ۭ���p>P^� �q-&�n�%@��\���˥w)�"�Z��[O��x~��|���܀8Pи+y��:jD7��Լ�MMB��G�@��"�w�^q�i��y(D�n�6����!�7V��w�e͒�Db��X+�l�O�3��ĮjG	t9Ӯ������e��&y�%�Pd�K��F*9w)����^M쪋#�Ȱ�$�T�=J)t+)��aBL�9������%����.�z��V�Oc�@�+K]r�׶�Ol#w��6�z�x�m���D�j�e��{����y`]���дg[C�1F��֢^ր��5�Y�=Z[	���%a��5�,QBb��� ޟ|�X�p�4u"	�sRI�2�O����(T|�s Qn��Ծ|��}䣞G�g<��u��I�%��j��<> >r�:o?��>�bqP�^q�;|���>0<������ �C��!�K��)�)>}P?;��������a~CaO�!5�'/A1{ǣ��_"R�^����?�����$'	oH����YlT��=V�r;ݐM�D=����o��(��y�Gp���������Yr��]�Q1�XY1�/İ`���9�8�x� ?bX������M�(B�;�07}q1��P�G@f��gA���2+�J�A�z�ADwE���8�;w���Q�p�L�:t���_���Q��X�?����!��v�i&Eӌr���&��:�r ��|�cxâ����_1Ѱ�6�F��)(?�\{�+�.0_�0a6���V�FB��x��5B�v��x�rNQ�?��mׁ��9��0���W1T�<X�4�8����E ����1-�IR|���P�=0�G���>�_r�T��n(�q��"fޞ�e+L��{Fw$�e>IL��O���/�AØ�q���\���e��9����V9(�w����8&+�q�"��2f��KL�! �^�	e�D����@7����1`
#ǲ�(�C�,繩0`�p�P��S
!�>EY��w�!ग़��9����;L�}>yH���@~�x�s�h�xfz[M����I*�l�8]���y��0�
8�!H��$��`K�_�;�`��5xި��8/~��<DM�+;Ć$y��ʞ��O2O�@�<V*��9���DJ�|�("��xD�FUaC	�Ч����;����7x �!eQ���N��ug!���_���_��f�p֖u�Ϛ�f����f���c9���������4A�&X�U�p�p�@c�-6��?�[_cd�E�4��\��!�%���Ё�`�>t���`E�_S����\uM�l����E��j��E�o���2O��;�:�2H��U:��z��+�C!�4���f�k�N_T�)xn�zH��`w�	��cyf٧��i���-�Fu:�F�k˽o�^���j��:���{�g=�gKL���(�oYr7Ǉukee�<�f����XkM_�`����3��Xfj�����h�)q�]��uϙ$B�ܩ��2��^Ʊ��$�xq�/��P��+��Kp��.h�k yPMwu'M�-Ef.;B$X|��0���<�t�׽�ǻ7; �6y4M�����<o���FQ�omi遹jF>(V��%�Ȋ������t6�*�tsYc8c�3T�!X>U���Y����u��`#���!3�߅� 	�4�(
�Ůd�i��6�­��wM�B+����F@$g߿�sr0v��sV'r�Z=��A�D.��\�!��=�Z:4�ր���α�����X��S�����|D��BV�K�Ճ]��r5��<V��\\"��g����ԕ�ػ�)1ѥ���� �WG���٘2�����*��nЕ����(y�O�l�3s�-J��Т<�W��\�bCdH<�sf�#�����	n��ж^��7 6e�X��2�֨]�+[���YL�A�+L�D儧�W'��(���A̿�%�c�ֺ(�O�	�~�B��zQa�,���)`��[d(vՔF�/���f܉��i�[�D���S.�t/هh	�r��6-�VC�"���0/�n�
m9�lO��M�Dgw�i�B��}���&\�L�}N�C�)��ViZn:�J�[�)t(�g�M�Ԫ�q�D��A�}5�v"�ϑ���o6ˆ�QKvwgdLA^�g:\M�?�¹��eeU�c���<i�C_���ח�c��u|�P]��ieΖ�TWz9,�{&�� �q����?�����\��qkR����A�M�X
����pE�m��YkX�b3���x�ڔ��\1z;�*���n5����x�u3�[�b����s�.GL�=����k8j�p�Jr�:n�"i;帕�ꙒS�e�*����Ӗ,ԷG���n�j���+kC�L�ި�����;�vzf�� ���ҿ?fg������ձ���v����ZU��E/����6�G \�������'�$�çk�tɆ$ �v��d7���^޻4�U��H�CUzlڭ\�+������rɭ񽕽;2���o�x�7�"L�w���U�;���}s�=�y�UQt��#�'5�����d 1��0����4������.ŀ`�=F���`���[�r�>�i���e1GETbBl�I�]�rWڣW9`	$��f�������*��8Ƭ4C�$���������05u\;�|����sbl�EO>�KSb8b���Hf�Cb�!�11�Z`G-sbJ��{D��Hŧ<$ƴHeq�*��P<���y$z�h����͑0��-I�T�j,���E�-X2D�%î���)*̢�P���͖�,����|zͻ�j���� ���˾�K_�V)o[�?̧AUX=<e��>�����(e�!�1S8�m��](��*8s�
(�׃��Z�M��M؍lB+���[ڤ�Uw�h�'Y��-�)�1�����B	,q&騾O��̖Z0;��Y��R���n����+Î��,�#9���߽����g�z2�����÷�0�u"Ν���I� hxDpÔQ:>I��q�j�p)CS�CW�
-��Ƹ�V��:��9�,�>����<�.��Kz�ֈ��3X*���t_!��Rx�ӻ�kp�8(�B�'�II,�8�����0����j:<��2��%M-����I87ij��vISs�i���t	�mx
oIS������1wKS�����,Mn�,��D>����f���xD�H$b���r������%,�R;+[^V��}i�F0�����o0�vF״VYd8�"�#w�g/bH��0[��Xϣ��?u�d�������������~�[8!� u�pBd,y��'�E��q@ȹ����Ǽ����;�p(e�802g<o
D�S���Tp���ա����!��}�r��U:��%q���ԴN�K�g���F�*z�e��z~�8?�Q�<�9h<��r���c�G�*����ιz����;Wyh棳0NrO�D�B&{��ۻ���a ���"'@q~H�<�Z튾!���USmp�>�N=�^l糇�#2�����g�3cϘ��(�cVOx�B\&�H�{�m��n~�=���З��`��_�.*s����8�	~���h�O�r�E��ϟ�:X�6�$�@�)[���~X�vޱ*n.FF��#�mGO�6ސ���|bH���jc�gn���^����ٳ��"��Wz^����ٷ�Jϯ@� �4~^g�K�3`z��+-V�'� ������u���:��u:kRGeX����1�_ �4�8q*/t�z�!�C�z�iz9$��{ӳj�93̗z��������M����E!|WaރNx8�#��Tb�D��g���46d�{�����~��{]���6�do]idq���=ਊF��$�{&�vt,H0���	9�	gu���Cwb�H�ό	;(>�oxH�B�{)�r.��E��?J�b����\����7�aY�����4��*Ʌ11sd@�#0�~����L��*78,[�_#:�ٿ�*��Z�����CUgXv ]   ��l��=(1se���V�wI������K,��Q$��`�D�CBI����`�<7��h�)�n=��X2;d.!�vx��h\�0��� 43],����?yy6e      {
     x����N�@�继���14uC
�X��-��3�]:�6���y1|t@A��n��������_Q�Y̢�`��j`�홙1K������	��-�Hip�d�`�>�`���Q��%Fkn��aH��U}L*'������^p���tP��Ċ� �p���&t���^`�۫i��v�M��o�M#�Ψ;|Ձj>��maooL�U������Z0�B0���Ss�Ԋr�GZMoJR�%�ρ-�2㐄[ԥ,���ىk�=B��s�g��n^f���Z�R��,      }
   ;   x�3�tN,�/VHIU-��2�JM/J��R�oN���2�(�/9��$� �+F��� ��      
      x������ � �      �
      x������ � �      �
   X   x�3�tvqu�4�2�tqv 2�9��2�RKRR�S��RK/,�Lʙp����T�Y.��@����2�h���'����� )(w      �
   S   x�3�(�ON-.�/V��+I-��/��MTH��M�+>�|hq�BAbQ�BIj1q� �gp~rfjJbJ*�A"�X4F��� ��      �
   7   x�3�4�4426153��4444B�c�M�9c�8��8rXY�� ùb���� �&T      �
     x����n�0�g�)�-x�H�c��C�!h�.]�ȑ,;pE2�Q:�%�둲��C�N�晿�>�H�Gb�C7�Kۅq���v��&mHܶcho���?��(h�OwaD�����-��k�7���'�����؄�	���Z����N�.<k�U�Vbh���>L������ܮ��j~FBPBR��I5�j$�H��T#�ƙ�H��� �A�	́��"�F�F���Rh�THP!Au HY���B�	,X$�H`��"��9�H`��!�C�	8$pH���!�C^ü3��/��i��L�X�<�v��0;(�%bS"�J��eتګwJ-���U-۵��kn�6���-g>z룢o��U�냧F�#�h_ ��kU���.КmU��ZW���yk
���������������������F� q�
2G� u�
rGjNH?v�0�|>��k;�o��bQ,�8ѧ�'�!��[��v{������A4�K�8��m?Do�"�65�s
�8b�fbG�����Ҙ"���'�I<uSt7���Q�oՃ��d�T|�<q:���Z�ѩ�����;����뺫�d��-�7�u�쇼ޅ���sxh7w����_{y��E��+�C��4N9�E�%Ҧ��$!�_,؆\��t;"ISf�̲�e2�dt6�dV>�GW����4���q-I���7{y-���t�⪕k����������Z�?����n�'I��S
�=�Q��Ageeu���se����e�e�e�e�e�e�e�eU����j��"�/      �
      x�3�LK̬HT0�47�4�4����� ?2c      �
   K   x�3�tL����,.)JL�/�4�2�LO-J�+I�-8C�K�2�lKΐ��T��N.CT�!א+F��� ���      �
   �   x�u�;�1�k�)r �&��%H4�rK	"+DPl���4\���f�g�ؖ"}ߟSX[�4 `G�2H�l�R��b˚�� ���i�N�xC��-�v���N�=���.�%�X�&jH~�׋B��!�>(�3�I�+�>LX�ݳ����x�1X�`�W��_�4�ݐxV3���mfk�_}���X'/�7�_`��,3���l ��I��[]d      �
   N   x�%��� �o2L�Ċ�K����n�0.� }KDV�TS`U�R��ꮭc���s��r�Zԯ5�e��� ��      �
   �   x���K!C�p�� �������n���>c�F�]�V������i�#Bc&���L��$r�H)�XN���~Z+9��+@&q�V����JT��$��Ȯ�Iӏ=��K����k��Q�9�$oa8���}��%:�����f�@���_t�kK      �
   �   x����!c�e}�A�^��:��nA��;��iZ�M�7�V��<��j���hL�l6��7JdPY�xʈ�Sg]E
X��MW�CQ�,���52;������M�L�Y �����)\��"%i�#'&eIc���}U~���Mp~֖�֧1���g�      �
   N   x�%���0�7��K�����A'9�[��#vH��=OB���E�R��k���ڦJ��]���JQ���= ~C��      �
   H   x�%��	�@�o3LQ�4���稗��$<�{�`I	�eYț,b��E���ZW��j�A���Y�������$      �
   p   x�=�11k�y:�^@AK�(��.[��پ���@[�jf�t%�g�lI���n�e�QP�Uo�dDIX&��� <�sJ^=в��v�#	mw^�5���^Qr�<�2ۅ��'D'T      �
   \   x�%���0ߢ�����&RA��#R�aG6������q��l��[��R	=�
��}�֌	+b,��r���_~+u����"�Ҝ�      �
   �  x��XKr�6]C��	X��N��=S.;��Lf5U���PH�H-t��R�B��X}�9eZ$_?4�Ѥ��3������eP2W�wU�x.E;K.SR�3ՃfT+��
�+Z�_M��,��ω��Y��sw.ݙF�2}W�BX�xc���h(�8k�ű�<��8=#��������8!^�W;��9��:�������XIy�G{J���(�64\B��ޚ�LR����Ͱ�нg�gcg(��AA]�-ɑ����I�O�_��s�g�'��d�j �EpU��㪗P	iUida~w�J�=���sj��5:a�������=���g�'���L4�|H���S���^�{�3���X�V�b�Q�x+�J�y6�G�
�A��r��uo1�*0��[�phj�+s�S�}���~f���^m��Gp�˖g�h˳��|L4�b\�g�}�G��t43�LF3G�w�|TD�wq.處���	�s����K|�Y��U�I�a%_��y�Z�9-��?ұ{s�N�(YԢ?�ro�`YC/.<�ϝG�t7��M&p�	�l7��-&p'�m>!n儸��VN�[9!n儸��VN�[9!n儸��F�	��ф��hB�h4!v4JI������qWe�9�J�+��Lp��,�\�5�J9nAh��qث�c�a�n�q�#8�e��Gv�q��zl���w\���'��#ր'$4;P���||�s��QԴ�{��[�[�F%�#�mEҽ�a�x��f���4M�s���#yd�Z�ѷ���/tlf�>��i����O(���Kֈ���օ����*�┽��Bi�Ӷ`�}S�&���z��ά�PzG� ���������AHp�g	[����$��"�${v^џ��#��:\Q��A-����F,\9�36&_AB<��q�	���u�gdNn_��Ѫ�#���D+Ѐ�������=�������<�
r'��?��A���w�U��7�����9��ؓ�6���5�w�=��S�@��<
JrǠl6�ՖmfFł��e�r� '�V�D���q^�]�
�,�̓ 4��	�����k�Ob���s� l��)�r_Kx��E�)��bb��,��1����Z�Q	�̛^t�#���������
<�S�7OL�&����G��N�54N��3�'�)μg�
�{}������g�;�Z]���wL��/�]����E=�r��v`��F^��Ӑ��<#r��+��2I�P�VJ-	�<�����zܨ.q)��G��%���$�f�����D7�R^p��nw�`�d�Ӄ��r��*���Z.�T���`����Z�'�����;� ��f)�ą�4�3!q�0z\ů��|{����6�K�_^����?�Z��      �
      x������ � �      �
   )   x�3����I��WHIUp<�|h9/�W0�4����� ��9      �
      x������ � �      �
      x��ZKsIr>��������Ej��H�P�I����]خn�V7�O����11k|�Q�c�2���`Ck�#�QTݝ���/U���٪4k����F�ҊJe��̍�e*��)d߫bar<�t�)��̕�d��r$~�|K�I1zӈW5h��(@DK�='B��A���;kf���T١�7;�K������8�='O�c����������~��<ۻQE����RܘLۿؽ�u��;]`�T�)Sk�Ja�\+aU�/�:�Ђ�o���L,�����ņ�����ӱH��ǧ�$�_ca���$��V��d#X�!	��Bj��虶�d�0uUbc�ħ���K��� �ۦ,Ū����)h��'��k,��N�*�W{¦�����Ӈ�0Z>���+�,�����>�=�ȤKFjZ��t��P�ҽF�d\2V��?�xD���/��!��!���e�5m�ˮ���`���}�
�W��#���i|(d#� iV�pe�����Ə���	��{ֿ|t2���?ߣ4�4kS����#v4�_�Ď�����-vJ:1�Y��N�T$P�׹o���-��)�p��q���+��k��1�e����x*��9O������������{�6G���C3*SB��G�A�i�[��<����P;ޟ���Y.Tf�k��R�2,�=	de����
��MX��j-eF�^W��>(;b�Cy*�:��/���T��[<+������#�`��Ґ���m
���"X4����ٍ�^)d#X��6M �Oi�ws��&y�*eF��o/�n�F�e.�
y&� I������Ҳ�J�Ж�� ���y(������9�6e���Vz��:���7o��~������h4:$�*}��\FGt$sS��?�� D�������^֚ 	H	��� �Ԏ��s�~ɿ�����s6kz..��K���6$bdc] ��{H����Ϳ��lK	:hK�8�c�E/y"��Ν�}����)0���!)�D��S���ZKgi���AZ6ܺ�
�^���\��Sa/Q8�לĻ�hu$��+������W��%e]�,XdvLes�b`��y�I$�i�^�X '����-�깮tI~��y�l�*�Wd�b�դ�!"��`�*�ppx`���VP#ق�w��D}�w!4YA�3�ş��nA6�.WTg�LU�;�T����9#����BЉO�j���������DjTJ�����<$W�x�Z��v���Ǚj�r�%��ꄩ,�m�0(���7�|% �vv	�R��j;p�ռ�:��$�����H>(<,Q�J�O��R���N#sa9�����?oQ�I����҄B,�P\ZE��(��ݡx�B�b�";��.�\�j���]R`�re|@�sd�0\HJ��T��Y#�p�	�m�����8�V��6���S@�<��9����|��;��� L�dH���EF^(�-�M�$�?��Q���#��AtmS�֟��]�(���_�o�I�D��!T�Rg�n*}���w�v��S�햣+��rF�oJQ�s3�ʮ8��~���bϫ�E���	y=�5$��J[�ǲ�}S�G�x�i���6���p$.6_�p�9��t�����Ƨ�$(῜��[^_�8��L������`��LKZ;4����m��m'ݐ��z3�h�8�B��,6Li��3{�EK�o��u��w�=�Er�!K�miO��OyH�钪��v���
�c�٣�"���W�F�W ��f�'��6I��gτk�)0۪��
=h%����gWP{�a&C�w���j9إr�*�ͯ)��k���0�Eh�c߶�y�0=��p@��[2�S��W��<Ж��6��}O)� '!D����?���=%�Wd�'�,�G:#g���+�O8S�a4,���G0h�ͯ��҇p�b���W��|�'���LK)0>p!HJ��!m��E���v)c���=�����Ըy�Y$�4�l(�g���*�]�N1CmYD������0 K�W2�R7��\Z���
!���2�Yo~y��b�s�a	�rm�H<�@7�Û�>�E�D�y�o-V�,�NM{cA�
տ��[H������Ձ�a*_�t��@�d6�[V�Xe���n�h��زQ�k�2&9�ᭋ�M�G��ie��C2)�J��jR��[rg8����o��+(��
S��Ӆk�J����U�EZ�v���E���[����!)�0v/-Ww�"T��]�Z/�񿹬�xn���8i���(�����Y�V�E�"+S�Ϳ��)'Ǔ�$���;2.�]��.ލ\%���w	�� ;*��R� ⟁���.^r��&�m��q8��ͨU�37�H8�3J�+������bנ>�Bwm����$��g;ɡ�JEǸi�-s?U��XBE�ې�;�"�]ي�P]��7UMA/����|W���c���;i��!�-�j)�w��Ÿ��Q�e��Qv8����h�D��|7'��;��(�e���E��F���RxSL'&B��p�d�t>}ֿ�&���)vݞ�nM;��ڌ�7V=�4��57VG���6�S���M�����[sB�ә����c :U�욶>�������I8ޟNw~wbZ�iH��?�G���S�l�/�t:�<�_��)����6_����C�1�ZʟHȊ(��6���dF�{�g�b%��i�Z���/�O�9&�Q<��G��c���� �0�� �B���.,���:[C\՚�4�;7x2��W��n�ȋ�ٔ����%�!M��Qe��P%�Y�L�
�AyHhtdh�Q���~w{��c�@���/GTT�J��|��l>x�ҙ����2s=�n����Ż���o�A�$u�$�D�r���L��nNŌ�#�(%�8��zG�(q6���y�C�U��̃$�0ꍳR&��/+�*68�
��2��]~RV��P4����-t#��Oůd�"�`Gl��~���;�vn��^�@2湷�Ԯmqe|̵�(�2��0%��O�c����׹1��L��^o�N\��kظ�l|(���LNG��j�/ס��:H��[z͢�Ye�f���� g�>�C:�q��qgi�U�?m�Ʌ��5y��
�V4�[��R�-�Pee�;�����Լ�����q�9/�����03��N��-��F^�x��ܤj莌Z>����#�����.��~j��tXV<,�}��v����F���wM��P��a�7�h�h��`���ֻBy�~���<l��)<۟���������3;hq�e��f<����ԍ�$w�CJ1�T�,�ך�˺>�O���f�c�J?Ģ�W� 3�}	�I ��Y��$�<�����Cwܗ��$ѻx�H遇4�!菑�Α���̌�$��#%��_��F� �Ͽ�]�5�FP��9����7Ё	j���8ߍp�e��x�(��ȱ`��ǅY˚�`+�z��3w���o$�����>���h,J�Pn�Q��%;�Y��v�Ų�qp!妗{�J7�=o��)ȓnІ�2���7�^���VEi��-��Xr�����=N���x2%'ǻjhT`Gs�_�k�j�[����qq7�{���-w|'�,ֵ�P��;��IB7���V������x�77�V�/���}���[`C4�@ ��Q�.?�L��;�:�������p�iʗ<�:7Gx�	]���_��_X@�k�7����\;�T+|/���w�'����Z0�l����H7(qR�c�J���"�Gx�;!�o����R�S��{GI���M@�Z�2q������]�\R9���9�iln��d>yl2��OBgd|Ρ�]��HK�.�Y��� Þ懨�ߚ���_�w��{��i��`��L@G]=������ߝ�����0��K7���G���M7��z��d�{�q�����h*W�h������o�]��<*D��"�� �o�yF��\Q#�C>���g��I�Ӻ���b�vG�����dҹ��^ a  ���E��߽ӓ�q�ⓙH����|rҿ}���C��1X����&�,�_s2=۟��+[ڝms�v��@r6������H��*�bQF$B,�����t� �w0�]����Z�p�1�"��ע�h�V�.����B,�Xq��[�fG���G��hbm|u���� ��E��+�F���dE��7���S�J�f��gə��y'�=��E�7k�ß��~�@%�����c�H���!�m͗<����l>=�_c1���#�qCD,wO���|F{�焰fk�q-�������� ����WG�-譵Hi��f�箂Ԇ. ��G৳-�G�v����p?����/�o�      �
   F   x�mĻ	�0�Z���K�\w&�O�:�=�g �{�H�{Iv��k@ͬ�R�n�^� !�ݘ��K      �
   �  x��ZK��>�����zk�(�
��`9�Bus�tZM���:{��`���e��?������ac�5��z|�Uq���V&�d�Gi�2�Ph��p�)�AZ%%V2��"�۟�?K����>?�X���RHq�z�Q�7����c����w7Q��Q4�F���F���/&ѽv�ZI�Ū��z������n�����wze6J;�H�ih6�_ج��7Lh���t�{�����.W�9:	-���ֽQw�"fY!S�Fu�*�*�V���2�����u]2�X[Cڊ�
&Ê�,���g,7N\��J<ȏ���o�b^��IY�։�?E���	r��~i�I�˭��3#J��!cI��f�Jg����	�w��������}�U��x���͋�8�S��Q.aD#�U_1�F�:lG.\�2�k��}2��b�r���,�m�W��Ni��0՗F<i��2���B�4�ȤXH�ᛰa`�;+�Kq�� )�)^Y�t�!������x��J�7VH�zCK|PB8�h�rk�%�e�����䚒G����X��ߓ2'�9���Y���˞ʌ�W��������x21�u�l[�Z�<8�5|�]G�N�Ű��������p�X%>锉��������5�ɖ��h���<���l�$EjĹ��6SH��B��
Ҽ?%��v8Q�,�+�Zj�P�(���'cW�.���˂7�ɪ�F���1����[c}�g��"F��K(4��;:�aǓ�p2"�9#�M"?H�q ����� _�{���Ս " �a8'���4d���l5~�'L4Δ9�&�`�pExNK(b:Զ���C�")�+p�0�u�PT��3[֯����F���M6�-�����rk�W��uc���V�Υ���7�^�`���
ԷϩvTm���6%,�Hyb���*�8o�V>�8ˁ���"<V{s���t<�0����E	���~vwK�rZ���t��v��R;�=_�΢�gʭj�}�Ce-��JL���z�┅G�P�&���q�Rn�XBzjnw�fߣG�4��(fD?Xe�����#v��l���'�<���@�h~���vCN�*�*���-i)$���k����߿�gѹ\�K<=�~�<�/I�.ҭec����Sm��ES�����,�����[��;���hb)2#t; 9)�C�2納 �qm�5G؃�ɀOy�Z]�����YN^ͨ���( �xcM�dE9�0�H�
2t��p] ����V�)I���7�g(����n?Sֹ�����b����4v�����Ð�3�.i]<<S;,K�,�O��y��8 [ ��xWW�m?ǚ��v�
p�HP]k������(۲�P�|(+�G�ʱj��&�U��t��E���@Y���6*s�0�؞��a���0���� b��8$� ��/_ޘ�3��2�ysou� �\:��z/���UU\T$�饰9�w&�-k�|��~�h�K��t�Jy�kέ�dRgDQCj��c��F���T���ޠ�MP��d;w(Z�^�R�fK��d�#�ɲE9��{����7���)�ה0�c���k��J����ξyj5�!F�����D\�%�8=�m
l��N�i�4���"8�4gl��s)�����<M�d�-s�� ���ߴ��1��t��1h�`�x�QC)DA+�Բ}2L������{J�������P���������]�QE�������YA���U�I���5���'++�ƅf�8�����׃ɨ��(�#�нְ�K1V�h�d�?�
��ȶVh7A�p��|�3���7ݥ��I^%�p�xK�4|����^0.��_˿��po��Xx��ʁ�W��*Nܨ8/�n���xT7��h�&Jm=­T,�r+�6�jY\�v���<D(���<DĸۛVi6����sʕ}��GH(�
;�G͵��3���	��U�*�!����0Z�\/�q34_��^ g���A���]�����X�w�u����+ݤ�F&��rQ���<�aO�щ��TŤj���ot��k ��ׄ���C7�H�Q�iCX� �� ahB�xG�[��%=��G?�(?��mNBg,�v�<���~�*���q��D/�+i-����]�Z��{���mڅ�ָ���ͣ3�M
�+t��_o�,i���e��� �%��>���?��ط'����+�U+��j���9>�JZU$��Q�:�/$H��]q��it���!�\�r���&�����vhW���7�-��^vX���U��{����5��PqWc�FͿ/�X�ڵ?U�N��T�1�F��Ke��n�ӯ�7��rb�u���{���ttv���x7:��L=�U'�ШP�h�1�?�G�ֳ�rd٦!x^����y�'���`�m�z��p���(�x;x<�(Z�<��]�B��P���v.��*NeV�,P�ޮ�>�y�|e��9������X9��Q�~^poe�����������鴃��h8�5��~Ͻ���X�*�<���]�m�i*d�?t���_!�Z�\�+�#4����qt^��+O]�NH:0v�̽*a�yI�� ql�` ��t&�N�AwmҐ��IMT���e��yV�� ��T��u��`��d����H�)��5IN����Y���s��D}�6Q���U��y�@^Q!��]]���f]K�<�RO~�u�>@=We�WH5�ue9�X0҃%{W����\��#.�z��R��K��w~��4|��42B�q"�x��<?E���,�"�~�x*�ܽu��}��n(ۼ�iN��e}i�&!��L��z<}p�2m]��	׉����~Z�C=z��#xNᖜ$��|�=��a?�a����أ���P�R��������Z�{0��(
�8Īp��ۀ�P�����^�b���e'K���l��4��uq������9t�T]����]�ݦ��jUKu���}u����MN�֫��g�$NG
���
ChAJ}-�fu�MLM���-��$*��v����/a�%�<��p~�K�Nb���mJ�����Z`�Cj�O1���7w���z9���*�4�'��Ϳr�n�Ci6��a2�ws���i\vQ�ٿ/o�������e��f��"(ޡ�`Z8����I��%�����Q��� S^Nި����7�aܸ�@s$u�=Lx���ne/�����E�e�#?޼
v�y���(6L������2�ez���ŋ�� ��      �
   �  x�}WKr�F]�������C�6���dK�C�$%o�IխR (�
�k5^��
/r�V��xi�dN2/�
��?
��BUe��|��0K�uS�j�̒�t��L��̾H^h�R[������rc�ۦ�*�5�4��#���6�Ŋ�.�%��-�T�Ҿv�V�oMj��yA��y�v�����Ū7�o��7�I�p�<��k��\mR�?ə��L�٣�)>����<���I^>1̦����|~��;pd~���σER�V�{�އM�3N��6�ػ�魱�l2�!��l2���l%������QHd��$b��W]H�f�؆s5Q�G;�W��76�t/K��UN�~MNY�:[ڭ#$O�5������um9��'��35;:F��!5_$g��i�Iy{紺J���{��rc]@1 �#{���QYw5�6�L�zl�3�h/E{	P��u��6�������(�(m(�'i#�j��N���}��өv�|.l+������N�������1����)�jL�R�vG�f���0MA�������� ��R�q�	*3�t{/��U�k�dJ���~Ro�ld�F�띞x�^�mJғ��̖0�{���?P;ʭC@�_�[��i�]J P�zeC:35�����&g(��^��/�p�T��=w!��� ǝ���g>��x�g�.*Э����{��V;ӈ!>w F������s95@
?�)_�_��S��V]_�#�C} 1����e2m�{o}~q�~ kH����F�sgݙOח��ǏJT =e�([¸)��"�Gh���8ʙ�Y��دՋ�۫k�x������J�����R��nn/�-��?_uz�X
�0��d��0��w���J�-�x/,'�o��Ȅ�m7�n�7D�Z�z�'b�6ʓ���JMoj��� �� �_�������P�oт�ل_�I�킍PE�c��X,��`Sk��S� I9?�-(�1+�rX���ٕ��IS�/d<��Nd��K���m"�����+u�� ���m��k%�K�_��*�=�;|K����|��`�j�o̰^H�#��O������t��#;�s��ؖh4���k������}T���=���V�<��k�`23� ��,�7�y+�i=�n�.
0�"�!��,��Dc_s�B4Y`���fڣ�g5�$V���PT=�*Hk�����k�U��1�����ViN�g/x��U]�χ��3Df��{#sO��`��5���fH�kn"+$P���[��i���ɒm��IC	Bte޴�O��܈s�m�O�2���(��7���}�V���9���&�ňU���Kgv-�H�������%�5I}e�]d44�0�6�x��]Y��b��?�0U�f4�.�9$w��p� d]��X�~�Ϝ~�M�<S7�/ׂ���2*a\K�ڌ�!��6��¹��f�����(���Z���Fq���� JB 7x��u��誄`������șp�g?.3үϲ�YXq�I���ӡ��<g_��2(1�'^��j���2��KP����j.'v��l��CI�jr���?�6�GK/I�n�wi��{����8JO'c�c�V����sW��	�n$��Ǖ�Q˛��%�3���(��țB&��|�����	r1C|0�2 L:n
$X͏�\`,��'��;\ s�훊-�F�t�4�c`y3�D� ��K�4�[yQ0>Eد0;æ���t.{�@jz[ PՊHT�}�C��!{�T� X���"#]���t�(����ְ0�"�ܔ�y�����*pI���k�+b�3�U�[��_P
�H�<���@y�
/ l%�2b5�=�_�9�n&ӣ`���)�{��p.����1@0�G�,�:)��"�9���j�-I�~hL��~#� �����e&b
��Mlu'xWr�Ԕa��~gu�G��W�?�M.�mr1=xyxpp�~L      �
   I   x����PB�5㘘�����:�%`�a���px�L����Sn/��e�u������C/��e�H�|      �
   l   x�m̱� ��z�aȡ�Z� 6�+�D� ��cs�5��_���b���9׼�胕M�)������%�/�����C��ԣh�ܙ�K�y�|AZ�����5=hRDt�n*K      �
   P   x����0CѳTL�����_G�Oo�6�<p-[2h���"�I�r�!��,Z!oo9�Ȣ/lm��=e�KNoY��?-{,      �
   �   x�]�;
�0D��)t�`9�ұ������-����R� �X)U�}3��p7�pR�L@��h��^_��������QPD�Ƥ%�F�Z�vPZm&��R�:��
��f��xym����C����vq�{8��'Zʑ��u[2o."t�� ��풡�P�}�ǆ1���E,      �
   Y  x��W�n�8>�O��SI��xo��vS4���=X�q	H�KJ�n��AE=�z����-��&�KL��|���7��w�u�5Ӣ*d�]�D�l��b�`��r��\sv/����ˤ)�
����UH�R�J�qz&���Fd^��C�=�%����+\O�p��tOxx+tl��F�yg$;�k<����f�`������\0Q�Z�8!���F���(�f�oŋ��J�ph�Y� ��e�����6�� �3�T9P���/�,EY!� 9��߾a����Igw|5ڇ�Hg^�������P������a!V�����Z�M����l��G�2N��mn���wZeʡJ���b���_�u8��̛kɛZ�7K�p���˕Ʒ)O�����f�ڞ�pw�Ezݷ�>�ǫ�Ļi��`I��Ť�A����$�D�Ԩ;N��ysU$Y%�T��0��Oy �>��]�4���6DNњTc�_�3�E��!v6�G���M��k%���tK(@F���*�L�&��a�J����JhNވ��?�Y�����AX�Z"-s����S�R�r�lH�I���,�h��89WJmK{/b�V����s�?�8�(q�{���d�/������ͯ޺��Tk�G8��k�V�ܲW� �����+y/�XU�o:I?a�U����FU,&G2��9�{/<#ZuH�Q�
�/���@�^��O�m��gd��4T�����x����n�4�������ROj&��/D
6m��_˦&x&4���-�^��l�jE�mD�V��x���ϑ�+��#���'��{l�=3�����\ej���j���8"�p�O��@U;��R_K�v�H{S��B&�gvN�� �j^ �-���{��N�����m��]���z��ߥ��й��_���]8:Qii��2?I<�^�C�������~s�������ǤM�6�ʝ�Gc>\2�1��3��`�k�|n�2��p(��T8�#�'Q�i���f�����߬�b#iN���
��5��~�4D�Pv�`�/$I|Uq�Ұ~FX�ۅk��M�mB��N����M9���Y��5�[���~����^mh���U��]��6���H�
�A����
#��Lݣ��d"W�!Կ�K;:�� ��a��S�hLq�OĈl�+��2�U$Ui�4���T�;���9��3�= Y�=�����$��c��Bf�m�'<Kl[��x�J���
��`��DƝ.���FSR3ʷ��w2�ɮKu�������������/I�U�y9 �f{5���K�ZMx���ٝ����;����l��d0��*��      �
   k  x����r�6�k�)n�4�K�"�-R{��]J���"O�p1#�іE���g?�
]���kD����P�������MF��<kuK!Q�^��2�#R�!JA77�y<]��T�r��Fa��6(P�Z�}�TC����`Z�Kc���3D� �2��>�q���\b���ns���B�S@�
��A��R�>ͺ��y���X	��qr�JU?>��Х�aiQ裻�K�>��
�w�یǊ�K�t����Q�N'��E��7a�RB�Ln��<��{K}U��Cl� i�"��sSW�o�ejKf/bY���#C)oMG���r#G���Vɖi�#G��ٳU�x@�\�X14�!��w����<Y� XI�х*y�<8Ip�r�響�k�8!�ҋ� ȞG����T@�3KU�_Ѓz6�t ���sS��J�c�̙�h-��s�Ò�>���Ս����Cn�<�$K�su�`�{�#����0ZW�B���)JET�u`aP�|�`a������i�r�.u���D��t�غ�/Nm*�~�Tj���4���9�V�ܣ��9X��uA��u�����Sk4\�j������pʣw�������@�9�0��g?SJ3�<ׂ�`u�ZN�W��vRȆ��uy��Z�N���nDF�$����A��rBq��+gDP�	t2��x���d���5#yVÂ�S�������e�b�ַ���C,��4��X~�0�&Ag7�����O�s��/p4���R�>9�]����2ۅ�[n�@��(!��8�a��L������?��*�a�,�*{�H��Bi/n�*�����MZ[GQ��z	�����!/�1,�.Σ���5)��!öD������5s�|�c���b?�Ê��ݧT�_�?��{�EvV�>��#qm�h򱣗~��a���������l���x����K�ҷ_دe&��c��m���`q-��i��
�+$��.��wc�V�B+�6J��Y�
#�p���}L���-��6�N� _���D��2�mPD+bT�h�S�ڠTc����b�����y�*t����&�(B$�	`�VX�c�(�9o1*oD��0��^�      �
      x�3�tL���LL��4��"�=... P��     