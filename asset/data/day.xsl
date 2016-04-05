<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Timetable in days</title>
            </head>
            <body>
                <h1>CIT4B timetable day facet</h1>
                <xsl:call-template name="timetable"/>
            </body>
        </html>
    </xsl:template> 
    <xsl:template name="timetable">
        <table border="solid">
            <tr>
                <th>Hours</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
            <xsl:for-each select="/data/timefacet/timeslot">
                <xsl:sort select="substring(substring-before(@whichtime, '-'), 5)"/>
                <xsl:call-template name="timeslot"/>
            </xsl:for-each>
        </table>   
    </xsl:template>
    <xsl:template name="timeslot">
        <tr>
            <td>
                <xsl:value-of select="@whichtime"/>
            </td>
			<td>
				<xsl:for-each select="booking">
					<xsl:if test="@day = 'Monday'">
						<xsl:call-template name="booking"/>
					</xsl:if>
				</xsl:for-each>
			</td>
			<td>
				<xsl:for-each select="booking">
					<xsl:if test="@day = 'Tuesday'">
						<xsl:call-template name="booking"/>
					</xsl:if>
				</xsl:for-each>
			</td>
			<td>
				<xsl:for-each select="booking">
					<xsl:if test="@day = 'Wednesday'">
						<xsl:call-template name="booking"/>
					</xsl:if>
				</xsl:for-each>
			</td>
			<td>
				<xsl:for-each select="booking">
					<xsl:if test="@day = 'Thursday'">
						<xsl:call-template name="booking"/>
					</xsl:if>
				</xsl:for-each>
			</td>
			<td>
				<xsl:for-each select="booking">
					<xsl:if test="@day = 'Friday'">
						<xsl:call-template name="booking"/>
					</xsl:if>
				</xsl:for-each>
			</td>
          
        </tr>
    </xsl:template>
    <xsl:template name="booking">
        
            <xsl:value-of select="@course"/><br/>
            <xsl:value-of select="@instructor"/><br/>
            <xsl:value-of select="@room"/><br/>
        
    </xsl:template>
	
        
</xsl:stylesheet>