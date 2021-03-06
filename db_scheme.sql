USE [simkatmawa]
GO
/****** Object:  Table [dbo].[Mstr_Capaian_Prestasi]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Capaian_Prestasi](
	[Capaian_Prestasi_Id] [int] NOT NULL,
	[Capaian_Prestasi] [varchar](250) NULL,
	[Created_By] [varchar](50) NULL,
	[Created_Date] [datetime] NULL,
	[Modified_By] [varchar](50) NULL,
	[Modified_Date] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Mstr_Department]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Department](
	[DEPARTMENT_ID] [int] NOT NULL,
	[NAME_OF_DEPARTMENT] [varchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Mstr_Fields]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Fields](
	[field_id] [int] IDENTITY(1,1) NOT NULL,
	[field] [varchar](255) NULL,
	[key] [varchar](50) NULL,
	[type] [varchar](50) NULL,
	[deskripsi] [text] NULL,
	[array] [text] NULL,
 CONSTRAINT [PK_Mstr_Fields] PRIMARY KEY CLUSTERED 
(
	[field_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Mstr_Jenis_Pengajuan]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Jenis_Pengajuan](
	[Jenis_Pengajuan_Id] [int] NOT NULL,
	[Jenis_Pengajuan] [varchar](250) NOT NULL,
	[Created_By] [varchar](50) NULL,
	[Created_Date] [datetime] NULL,
	[Modified_By] [varchar](50) NULL,
	[Modified_Date] [datetime] NULL,
	[parent] [int] NULL,
	[deskripsi] [text] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Mstr_Role]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Role](
	[role_id] [int] IDENTITY(1,1) NOT NULL,
	[role] [varchar](20) NULL,
 CONSTRAINT [PK_Mstr_Role] PRIMARY KEY CLUSTERED 
(
	[role_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Mstr_Status_Pesan]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Status_Pesan](
	[status_pesan_id] [int] IDENTITY(1,1) NOT NULL,
	[id_status] [int] NULL,
	[role] [int] NULL,
	[icon] [varchar](50) NULL,
	[badge] [varchar](15) NULL,
	[alert] [text] NULL,
	[judul_notif] [varchar](255) NULL,
	[isi_notif] [text] NULL,
 CONSTRAINT [PK_Mstr_Status_Pesan] PRIMARY KEY CLUSTERED 
(
	[status_pesan_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Mstr_Tingkat_Prestasi]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Mstr_Tingkat_Prestasi](
	[Tingkat_Prestasi_Id] [int] IDENTITY(1,1) NOT NULL,
	[Tingkat_Prestasi] [varchar](50) NOT NULL,
	[Created_By] [varchar](50) NULL,
	[Created_Date] [datetime] NULL,
	[Modified_By] [varchar](50) NULL,
	[Modified_Date] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Field_Value]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Field_Value](
	[field_value_id] [int] IDENTITY(1,1) NOT NULL,
	[value] [varchar](255) NULL,
	[pengajuan_id] [nchar](10) NULL,
	[field_id] [nchar](10) NULL,
	[verifikasi] [tinyint] NULL,
 CONSTRAINT [PK_Tr_Field_Value] PRIMARY KEY CLUSTERED 
(
	[field_value_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Media]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Media](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nim] [nchar](20) NULL,
	[file] [text] NULL,
	[thumb] [text] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Penerbitan_Pengajuan]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Penerbitan_Pengajuan](
	[id_penerbitan_pengajuan] [int] IDENTITY(1,1) NOT NULL,
	[id_periode] [int] NULL,
	[id_pengajuan] [int] NULL,
	[pic] [int] NULL,
	[STUDENTID] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Pengajuan]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Pengajuan](
	[pengajuan_id] [int] IDENTITY(1,1) NOT NULL,
	[Jenis_Pengajuan_Id] [int] NULL,
	[nim] [varchar](20) NULL,
 CONSTRAINT [PK_Tr_Pengajuan] PRIMARY KEY CLUSTERED 
(
	[pengajuan_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Pengajuan_Field]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Pengajuan_Field](
	[pengajuan_fields_id] [int] IDENTITY(1,1) NOT NULL,
	[Jenis_Pengajuan_Id] [int] NULL,
	[field_id] [int] NULL,
	[terpakai] [int] NULL,
 CONSTRAINT [PK_Tr_Pengajuan_Field] PRIMARY KEY CLUSTERED 
(
	[pengajuan_fields_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Pengajuan_Status]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Pengajuan_Status](
	[status_pengajuan_id] [int] IDENTITY(1,1) NOT NULL,
	[date] [datetime] NULL,
	[pic] [varchar](20) NULL,
	[pengajuan_id] [int] NULL,
	[status_id] [int] NULL,
 CONSTRAINT [PK_Tr_Pengajuan_Status] PRIMARY KEY CLUSTERED 
(
	[status_pengajuan_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Periode_Penerbitan]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Periode_Penerbitan](
	[id_periode] [int] NOT NULL,
	[nama_periode] [varchar](50) NULL,
	[tanggal] [varchar](200) NULL,
	[status] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Tr_Status]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tr_Status](
	[status_id] [int] IDENTITY(1,1) NOT NULL,
	[status] [varchar](50) NULL,
	[icon] [varchar](30) NULL,
	[badge] [varchar](50) NULL,
	[alert] [text] NULL,
 CONSTRAINT [PK_Tr_Status] PRIMARY KEY CLUSTERED 
(
	[status_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] NOT NULL,
	[username] [varchar](50) NULL,
	[password] [varchar](255) NULL,
	[email] [varchar](255) NULL,
	[telp] [varchar](14) NULL,
	[role] [int] NULL,
	[fullname] [varchar](100) NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
 CONSTRAINT [PK_users] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[V_Dosen]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Dosen](
	[id_pegawai] [int] NOT NULL,
	[nik] [varchar](25) NULL,
	[nama] [varchar](229) NULL,
	[unitkerja] [varchar](70) NULL,
	[status_kepegawaian] [varchar](75) NULL,
	[status_aktif] [varchar](9) NOT NULL,
	[jabatan_struktural] [varchar](100) NULL,
	[unitkerja_struktural] [varchar](70) NULL,
	[unitkerja_strukturalid] [int] NULL,
	[nidn] [varchar](25) NULL,
	[jabatan_fungsional] [varchar](75) NULL,
	[tingkat_pendidikan] [varchar](25) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[V_Mahasiswa]    Script Date: 06/03/2021 14:35:12 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Mahasiswa](
	[STUDENTID] [varchar](15) NOT NULL,
	[FULLNAME] [varchar](50) NULL,
	[NAME_OF_FACULTY] [varchar](200) NULL,
	[NAME_OF_DEPARTMENT] [varchar](150) NULL,
	[email] [varchar](60) NULL,
	[DEPARTMENT_ID] [int] NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Mstr_Fields] ADD  CONSTRAINT [DF__Mstr_Fiel__array__4D5F7D71]  DEFAULT (NULL) FOR [array]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Mstr_Fields', @level2type=N'COLUMN',@level2name=N'array'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Tr_Pengajuan_Status', @level2type=N'COLUMN',@level2name=N'pengajuan_id'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'Tr_Pengajuan_Status', @level2type=N'COLUMN',@level2name=N'status_id'
GO
